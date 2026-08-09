<?php

// Define minimum supported PHP version
define('NUVISACCOUNTING_PHP', '8.1.0');

// Check PHP version
if (version_compare(PHP_VERSION, NUVISACCOUNTING_PHP, '<')) {
    $message = 'Error: Ask your hosting provider to use PHP ' . NUVISACCOUNTING_PHP . ' or higher for HTTP, CLI, and php command.' . PHP_EOL . PHP_EOL . 'Current PHP version: ' . PHP_VERSION . PHP_EOL;

    if (defined('STDOUT')) {
        fwrite(STDOUT, $message);
    } else {
        echo($message);
    }

    die(1);
}

// Load composer for core
require __DIR__ . '/../vendor/autoload.php';
