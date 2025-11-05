<?php

namespace App\Controllers;

class Contacts extends BaseController
{
    // 📋 Mostrar todos los contactos
    public function index()
    {
        // Leer el archivo CSV
        $csvFile = WRITEPATH . 'contacts.csv';
        $contacts = [];
        
        if (file_exists($csvFile)) {
            $handle = fopen($csvFile, 'r');
            if ($handle) {
                // Saltar la cabecera
                fgetcsv($handle);
                
                // Leer todos los contactos
                while (($row = fgetcsv($handle)) !== false) {
                    $contacts[] = [
                        'name' => $row[0] ?? '',
                        'phone' => $row[1] ?? '',
                        'email' => $row[2] ?? ''
                    ];
                }
                fclose($handle);
            }
        }
        
        return view('contacts/index', ['contacts' => $contacts]);
    }
    
    // ➕ Formulario para añadir contacto
    public function create()
    {
        return view('contacts/create');
    }
    
    // 💾 Guardar nuevo contacto
    public function store()
    {
        // Validar datos simples
        $name = $this->request->getPost('name');
        $phone = $this->request->getPost('phone');
        $email = $this->request->getPost('email');
        
        if (empty(trim($name))) {
            return redirect()->back()->with('error', 'El nombre es requerido')->withInput();
        }
        
        // Validar email si se proporciona
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Email inválido')->withInput();
        }
        
        // Añadir al CSV (igual que nuestro script original)
        $csvFile = WRITEPATH . 'contacts.csv';
        
        // Crear archivo si no existe
        if (!file_exists($csvFile)) {
            $handle = fopen($csvFile, 'w');
            fputcsv($handle, ['Name', 'Phone', 'Email']);
            fclose($handle);
        }
        
        // Añadir nuevo contacto
        $handle = fopen($csvFile, 'a');
        fputcsv($handle, [trim($name), trim($phone), trim($email)]);
        fclose($handle);
        
        return redirect()->to('/contacts')->with('success', '¡Contacto añadido!');
    }
    
    // 📥 Exportar a CSV
    public function export()
    {
        $csvFile = WRITEPATH . 'contacts.csv';
        
        if (!file_exists($csvFile)) {
            return redirect()->to('/contacts')->with('error', 'No hay contactos para exportar');
        }
        
        // Descargar el archivo
        return $this->response->download($csvFile, null);
    }
}
