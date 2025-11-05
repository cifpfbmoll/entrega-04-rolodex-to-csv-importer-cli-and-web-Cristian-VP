@#!/usr/bin/env php
<?php

/**
 * Standalone Rolodex Contact Importer
 * 
 * A simple command-line tool to import contacts from physical Rolodex to CSV format.
 * This is a standalone version that doesn't require full CodeIgniter setup.
 */

// Define basic constants
define('ROOTPATH', __DIR__ . '/');
define('WRITEPATH', __DIR__ . '/writable/');

// Create writable directory if it doesn't exist
if (!is_dir(WRITEPATH)) {
    mkdir(WRITEPATH, 0755, true);
}

/**
 * Simple CLI helper class
 */
class SimpleCLI
{
    public static function write($text, $color = null)
    {
        echo $text . PHP_EOL;
    }

    public static function prompt($text)
    {
        echo $text . ': ';
        return trim(fgets(STDIN));
    }

    public static function error($text)
    {
        echo 'ERROR: ' . $text . PHP_EOL;
    }

    public static function newLine()
    {
        echo PHP_EOL;
    }
}

/**
 * Contact Importer Class
 */
class ContactImporter
{
    private $csvFilePath;

    public function __construct()
    {
        $this->csvFilePath = WRITEPATH . 'contacts.csv';
    }

    public function run()
    {
        // Display welcome message
        SimpleCLI::write('===========================================', 'green');
        SimpleCLI::write('  Rolodex Contact Importer', 'green');
        SimpleCLI::write('===========================================', 'green');
        SimpleCLI::newLine();
        SimpleCLI::write('Enter contact information from your physical Rolodex.');
        SimpleCLI::write('Type "exit" or "quit" at the Name prompt to finish.');
        SimpleCLI::newLine();

        // Initialize CSV file with header if needed
        $this->initializeCsvFile();

        // Main input loop
        $contactCount = 0;
        while (true) {
            SimpleCLI::write('-------------------------------------------', 'yellow');
            
            // Prompt for Full Name
            $name = SimpleCLI::prompt('Full Name');
            
            // Check for exit condition
            if (strtolower(trim($name)) === 'exit' || strtolower(trim($name)) === 'quit') {
                SimpleCLI::newLine();
                SimpleCLI::write("Import session completed. Total contacts added: {$contactCount}", 'green');
                SimpleCLI::write("CSV file location: {$this->csvFilePath}", 'cyan');
                break;
            }

            // Skip if name is empty
            if (empty(trim($name))) {
                SimpleCLI::error('Name cannot be empty. Please try again or type "exit" to quit.');
                SimpleCLI::newLine();
                continue;
            }

            // Prompt for Phone Number
            $phone = SimpleCLI::prompt('Phone Number');

            // Prompt for Email Address
            $email = SimpleCLI::prompt('Email Address');

            // Append contact to CSV
            if ($this->appendContactToCsv($name, $phone, $email)) {
                $contactCount++;
                SimpleCLI::write("✓ Contact saved successfully!", 'green');
            } else {
                SimpleCLI::error("✗ Failed to save contact. Please try again.");
            }

            SimpleCLI::newLine();
        }
    }

    /**
     * Initialize CSV file with header if it doesn't exist or is empty
     */
    private function initializeCsvFile(): void
    {
        // Check if file exists and is not empty
        if (!file_exists($this->csvFilePath) || filesize($this->csvFilePath) === 0) {
            // Create directory if it doesn't exist
            $directory = dirname($this->csvFilePath);
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            // Write header row
            $file = fopen($this->csvFilePath, 'w');
            if ($file !== false) {
                fputcsv($file, ['Name', 'Phone', 'Email']);
                fclose($file);
                SimpleCLI::write("CSV file initialized: {$this->csvFilePath}", 'cyan');
                SimpleCLI::newLine();
            } else {
                SimpleCLI::error("Failed to initialize CSV file at: {$this->csvFilePath}");
                SimpleCLI::newLine();
            }
        } else {
            SimpleCLI::write("Using existing CSV file: {$this->csvFilePath}", 'cyan');
            SimpleCLI::newLine();
        }
    }

    /**
     * Append a contact row to the CSV file
     */
    private function appendContactToCsv(string $name, string $phone, string $email): bool
    {
        // Open file in append mode
        $file = fopen($this->csvFilePath, 'a');
        
        if ($file === false) {
            return false;
        }

        // Write the contact data as a CSV row
        $result = fputcsv($file, [
            trim($name),
            trim($phone),
            trim($email)
        ]);

        fclose($file);

        return $result !== false;
    }
}

// Create and run the importer
$importer = new ContactImporter();
$importer->run();
