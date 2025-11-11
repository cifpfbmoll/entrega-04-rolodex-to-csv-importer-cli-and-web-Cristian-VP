#!/usr/bin/env php
<?php
/**
 * 🔍 Buscador de Contactos en CSV
 * 
 * Busca contactos por nombre en el archivo CSV del Rolodex
 * Uso: php contact-search.php <nombre>
 */

define('ROOTPATH', __DIR__ . '/');
define('WRITEPATH', __DIR__ . '/writable/');

// Colores para la terminal
class Color {
    public static function green($text) { return "\033[32m{$text}\033[0m"; }
    public static function yellow($text) { return "\033[33m{$text}\033[0m"; }
    public static function red($text) { return "\033[31m{$text}\033[0m"; }
    public static function cyan($text) { return "\033[36m{$text}\033[0m"; }
    public static function bold($text) { return "\033[1m{$text}\033[0m"; }
}

// Banner
echo Color::cyan("╔════════════════════════════════════════╗\n");
echo Color::cyan("║  🔍 Buscador de Contactos Rolodex    ║\n");
echo Color::cyan("╔════════════════════════════════════════╗\n");
echo "\n";

$csvFile = WRITEPATH . 'contacts.csv';

// Verificar que existe el archivo
if (!file_exists($csvFile)) {
    echo Color::red("❌ ERROR: El archivo CSV no existe en: $csvFile\n");
    echo Color::yellow("   Ejecuta primero 'php contact-importer.php' para crear contactos.\n");
    exit(1);
}

// Obtener término de búsqueda
$searchTerm = $argv[1] ?? null;

if (empty($searchTerm)) {
    echo Color::yellow("📖 Uso: php contact-search.php <nombre>\n");
    echo Color::yellow("   Ejemplo: php contact-search.php Juan\n\n");
    
    // Mostrar estadísticas del CSV
    $lines = file($csvFile);
    $total = count($lines) - 1; // Excluir cabecera
    echo Color::cyan("📊 Total de contactos en el sistema: ") . Color::bold($total) . "\n";
    echo Color::cyan("📁 Ubicación del CSV: ") . $csvFile . "\n\n";
    
    // Mostrar los primeros 5 contactos como ejemplo
    echo Color::bold("📋 Primeros contactos (ejemplo):\n");
    echo str_repeat("─", 60) . "\n";
    for ($i = 1; $i <= min(5, $total); $i++) {
        if (isset($lines[$i])) {
            $data = str_getcsv(trim($lines[$i]));
            printf("   %d. %s\n", $i, Color::green($data[0] ?? ''));
        }
    }
    echo "\n";
    exit(0);
}

// Realizar búsqueda
echo Color::bold("🔎 Buscando: ") . Color::yellow("\"$searchTerm\"") . "\n";
echo str_repeat("─", 60) . "\n\n";

$file = fopen($csvFile, 'r');
$header = fgetcsv($file); // Leer cabecera
$results = [];
$lineNumber = 1;

while (($data = fgetcsv($file)) !== false) {
    $lineNumber++;
    // Buscar en el nombre (case-insensitive)
    if (isset($data[0]) && stripos($data[0], $searchTerm) !== false) {
        $results[] = [
            'line' => $lineNumber,
            'name' => $data[0] ?? '',
            'phone' => $data[1] ?? '',
            'email' => $data[2] ?? ''
        ];
    }
}
fclose($file);

// Mostrar resultados
if (empty($results)) {
    echo Color::red("❌ No se encontraron contactos con el nombre: \"$searchTerm\"\n\n");
    echo Color::yellow("💡 Sugerencias:\n");
    echo "   - Verifica la ortografía\n";
    echo "   - Prueba con solo una parte del nombre\n";
    echo "   - Ejecuta sin parámetros para ver todos los contactos\n\n";
    exit(0);
}

// Mostrar resultados encontrados
$count = count($results);
echo Color::green("✅ Encontrados $count contacto(s):\n\n");

// Tabla de resultados
$maxNameLen = max(array_map(fn($r) => mb_strlen($r['name']), $results));
$maxPhoneLen = max(array_map(fn($r) => mb_strlen($r['phone']), $results));
$maxEmailLen = max(array_map(fn($r) => mb_strlen($r['email']), $results));

// Ajustar anchos mínimos
$nameWidth = max($maxNameLen, 15);
$phoneWidth = max($maxPhoneLen, 12);
$emailWidth = max($maxEmailLen, 20);

// Encabezado de tabla
$border = "┌─" . str_repeat("─", $nameWidth + 2) . 
          "┬─" . str_repeat("─", $phoneWidth + 2) . 
          "┬─" . str_repeat("─", $emailWidth + 2) . "┐";
echo $border . "\n";

printf("│ " . Color::bold("%-{$nameWidth}s") . " │ " . 
       Color::bold("%-{$phoneWidth}s") . " │ " . 
       Color::bold("%-{$emailWidth}s") . " │\n", 
       "Nombre", "Teléfono", "Email");

$separator = "├─" . str_repeat("─", $nameWidth + 2) . 
             "┼─" . str_repeat("─", $phoneWidth + 2) . 
             "┼─" . str_repeat("─", $emailWidth + 2) . "┤";
echo $separator . "\n";

// Filas de datos
foreach ($results as $result) {
    printf("│ " . Color::green("%-{$nameWidth}s") . " │ " . 
           Color::cyan("%-{$phoneWidth}s") . " │ " . 
           "%-{$emailWidth}s │\n",
           mb_substr($result['name'], 0, $nameWidth),
           mb_substr($result['phone'], 0, $phoneWidth),
           mb_substr($result['email'], 0, $emailWidth));
}

$footer = "└─" . str_repeat("─", $nameWidth + 2) . 
          "┴─" . str_repeat("─", $phoneWidth + 2) . 
          "┴─" . str_repeat("─", $emailWidth + 2) . "┘";
echo $footer . "\n\n";

echo Color::cyan("📊 Estadísticas:\n");
echo "   • Contactos encontrados: " . Color::bold($count) . "\n";
echo "   • Líneas del CSV revisadas: " . Color::bold($lineNumber - 1) . "\n";
echo "   • Término de búsqueda: " . Color::yellow("\"$searchTerm\"") . "\n\n";

echo Color::green("✅ Búsqueda completada exitosamente\n");

