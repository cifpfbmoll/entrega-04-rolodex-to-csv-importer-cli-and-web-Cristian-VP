#!/usr/bin/env php
<?php

/**
 * Simple CLI runner for ContactImport command
 */

// Define basic constants
define('FCPATH', __DIR__ . '/');
define('ROOTPATH', __DIR__ . '/');
define('APPPATH', __DIR__ . '/app/');
define('WRITEPATH', __DIR__ . '/writable/');

// Load composer autoloader
require __DIR__ . '/vendor/autoload.php';

// Load our constants
require APPPATH . 'Config/Constants.php';

// Create writable directory if it doesn't exist
if (!is_dir(WRITEPATH)) {
    mkdir(WRITEPATH, 0755, true);
}

// Include our command
require APPPATH . 'Commands/ContactImport.php';

// Create a simple CLI class to simulate CodeIgniter CLI
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

// Mock the CLI class for our command
if (!class_exists('CodeIgniter\CLI\CLI')) {
    class_alias('SimpleCLI', 'CodeIgniter\CLI\CLI');
}

// Create a mock BaseCommand class
if (!class_exists('CodeIgniter\CLI\BaseCommand')) {
    abstract class BaseCommand
    {
        protected $group;
        protected $name;
        protected $description;
        protected $usage;

        abstract public function run(array $params);
    }
}

// Create the command and run it
$command = new \App\Commands\ContactImport();
$command->run([]);
