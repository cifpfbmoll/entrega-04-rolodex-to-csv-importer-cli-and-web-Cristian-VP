<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ContactImport extends BaseCommand
{
    protected $group = 'Import';
    protected $name = 'import:contacts';
    protected $description = 'Importa contactos desde fichas físicas al CSV writable/contacts.csv';
    protected $usage = 'php spark import:contacts';

    protected string $csvFilePath;

    public function __construct()
    {
        $this->csvFilePath = WRITEPATH . 'contacts.csv';
    }

    public function run(array $params)
    {
        $this->welcome();
        $this->initializeCsvFile();
        $this->loop();
    }

    private function welcome(): void
    {
        CLI::write('===========================================');
        CLI::write('  Rolodex Contact Importer');
        CLI::write('===========================================');
        CLI::newLine();
        CLI::write('Introduce datos de contacto desde tu Rolodex físico.');
        CLI::write('Escribe "exit" o "quit" en Nombre para terminar.');
        CLI::newLine();
    }

    private function loop(): void
    {
        $count = 0;
        while (true) {
            CLI::write('-------------------------------------------');
            $name = CLI::prompt('Nombre completo');
            if ($this->isExit($name)) {
                CLI::newLine();
                CLI::write("Sesión completada. Total contactos agregados: {$count}");
                CLI::write("Archivo CSV: {$this->csvFilePath}");
                break;
            }
            if ($this->isBlank($name)) {
                CLI::error('El nombre no puede estar vacío. Intenta de nuevo o escribe exit.');
                CLI::newLine();
                continue;
            }
            $phone = CLI::prompt('Teléfono');
            $email = CLI::prompt('Email');

            if ($this->appendContactToCsv($name, $phone, $email)) {
                $count++;
                CLI::write('\u2713 Contacto guardado');
            } else {
                CLI::error('\u2717 Error al guardar el contacto');
            }
            CLI::newLine();
        }
    }

    private function isExit(?string $value): bool
    {
        $v = strtolower(trim((string)$value));
        return in_array($v, ['exit','quit'], true);
    }

    private function isBlank(?string $value): bool
    {
        return trim((string)$value) === '';
    }

    private function initializeCsvFile(): void
    {
        if (! file_exists($this->csvFilePath) || filesize($this->csvFilePath) === 0) {
            $dir = dirname($this->csvFilePath);
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $fp = fopen($this->csvFilePath, 'w');
            if ($fp === false) {
                CLI::error('No se pudo inicializar el archivo CSV');
                return;
            }
            fputcsv($fp, ['Name','Phone','Email']);
            fclose($fp);
            CLI::write("CSV inicializado: {$this->csvFilePath}");
            CLI::newLine();
        } else {
            CLI::write("Usando CSV existente: {$this->csvFilePath}");
            CLI::newLine();
        }
    }

    private function appendContactToCsv(string $name, string $phone, string $email): bool
    {
        $fp = fopen($this->csvFilePath, 'a');
        if ($fp === false) {
            return false;
        }
        $ok = fputcsv($fp, [trim($name), trim($phone), trim($email)]);
        fclose($fp);
        return $ok !== false;
    }
}

