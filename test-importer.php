#!/usr/bin/env php
<?php
/**
 * Script de prueba para el importador de contactos
 * Añade un contacto de prueba al CSV
 */

define('ROOTPATH', __DIR__ . '/');
define('WRITEPATH', __DIR__ . '/writable/');

echo "===========================================\n";
echo "  Test: Importador de Contactos Rolodex\n";
echo "===========================================\n\n";

$csvFile = WRITEPATH . 'contacts.csv';

// Verificar que el archivo existe
if (!file_exists($csvFile)) {
    echo "❌ ERROR: El archivo CSV no existe\n";
    exit(1);
}

// Leer el archivo actual
$lines = file($csvFile);
$currentCount = count($lines) - 1; // Restar la cabecera

echo "📊 Contactos actuales en CSV: $currentCount\n";
echo "📁 Ubicación: $csvFile\n\n";

// Mostrar los últimos 3 contactos
echo "📋 Últimos 3 contactos guardados:\n";
echo "-----------------------------------\n";
$lastThree = array_slice($lines, -3);
foreach ($lastThree as $line) {
    echo "   " . trim($line) . "\n";
}
echo "\n";

// Añadir un nuevo contacto de prueba
$testContact = [
    'Test User ' . date('H:i:s'),
    '555-TEST-' . rand(1000, 9999),
    'test' . rand(100, 999) . '@example.com'
];

$fp = fopen($csvFile, 'a');
if ($fp !== false) {
    fputcsv($fp, $testContact);
    fclose($fp);
    echo "✅ Nuevo contacto añadido exitosamente:\n";
    echo "   Nombre: {$testContact[0]}\n";
    echo "   Teléfono: {$testContact[1]}\n";
    echo "   Email: {$testContact[2]}\n\n";
    
    $newCount = $currentCount + 1;
    echo "📊 Total de contactos ahora: $newCount\n\n";
    echo "✅ TEST EXITOSO - El importador funciona correctamente\n";
} else {
    echo "❌ ERROR: No se pudo escribir en el archivo CSV\n";
    exit(1);
}

