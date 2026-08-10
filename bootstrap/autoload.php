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

if (!function_exists('show_missing_dependencies_error')) {
    function show_missing_dependencies_error() {
        if (php_sapi_name() === 'cli') {
            $message = PHP_EOL . "\033[31;1m============================================================\033[0m" . PHP_EOL;
            $message .= "\033[31;1m               NuvisAccounting - Installation Error         \033[0m" . PHP_EOL;
            $message .= "\033[31;1m============================================================\033[0m" . PHP_EOL;
            $message .= "Missing or incompatible dependencies!" . PHP_EOL . PHP_EOL;
            $message .= "NuvisAccounting requires external PHP dependencies (Composer packages)." . PHP_EOL;
            $message .= "Currently, the autoload file or required core Laravel classes are missing." . PHP_EOL . PHP_EOL;
            $message .= "To resolve this issue, please run:" . PHP_EOL;
            $message .= "  \033[32;1mcomposer install --no-dev --prefer-dist\033[0m" . PHP_EOL . PHP_EOL;
            $message .= "Or upload the correct 'vendor' directory to your server root directory." . PHP_EOL;
            $message .= "Please do NOT copy the 'vendor' folder from another application." . PHP_EOL;
            $message .= "\033[31;1m============================================================\033[0m" . PHP_EOL . PHP_EOL;

            fwrite(defined('STDERR') ? STDERR : STDOUT, $message);
            exit(1);
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-Type: text/html; charset=utf-8');
            ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation Error - NuvisAccounting</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #f3f4f6;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl w-full space-y-8 bg-white p-8 sm:p-10 rounded-2xl shadow-xl border border-gray-100">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                <svg class="h-10 w-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                Missing or Incompatible Dependencies
            </h2>
            <p class="mt-3 text-lg text-gray-500">
                NuvisAccounting is missing some essential framework or package classes.
            </p>
        </div>

        <div class="mt-8 space-y-6 text-gray-700">
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 font-medium">
                            Why am I seeing this?
                        </p>
                        <p class="text-sm text-red-600 mt-1">
                            This typically happens if the <code>vendor</code> folder was not uploaded, is incomplete, or was copied from a different application. NuvisAccounting depends on a specific set of Composer packages that must match the application requirements.
                        </p>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-xl font-bold text-gray-900 border-b pb-2">How to Fix This:</h3>

                <div class="space-y-4">
                    <div>
                        <h4 class="text-md font-semibold text-gray-800 flex items-center">
                            <span class="flex items-center justify-center h-6 w-6 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold mr-2">A</span>
                            Option A: Install using Composer (Recommended)
                        </h4>
                        <p class="text-sm text-gray-600 ml-8 mt-1">
                            If you have SSH/Terminal access to your server, run the following commands in your NuvisAccounting root directory:
                        </p>
                        <div class="bg-gray-900 text-gray-100 p-4 rounded-lg font-mono text-sm ml-8 mt-2 overflow-x-auto select-all shadow-inner">
                            composer install --no-dev --prefer-dist
                        </div>
                    </div>

                    <div class="pt-4">
                        <h4 class="text-md font-semibold text-gray-800 flex items-center">
                            <span class="flex items-center justify-center h-6 w-6 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold mr-2">B</span>
                            Option B: Upload via ZIP (Shared Hosting)
                        </h4>
                        <p class="text-sm text-gray-600 ml-8 mt-1">
                            If your hosting provider does not support Composer or SSH access, follow these steps:
                        </p>
                        <ol class="list-decimal list-inside text-sm text-gray-600 ml-8 mt-2 space-y-1">
                            <li>Run <code class="bg-gray-100 px-1 py-0.5 rounded font-mono text-xs">composer install --no-dev --prefer-dist</code> on your local computer in the NuvisAccounting folder.</li>
                            <li>Compress the generated <code class="bg-gray-100 px-1 py-0.5 rounded font-mono text-xs">vendor</code> directory into a <code class="font-semibold">vendor.zip</code> file.</li>
                            <li>Upload <code class="font-semibold">vendor.zip</code> to your server's NuvisAccounting root directory.</li>
                            <li>Extract the ZIP file on your server using your hosting control panel's File Manager.</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg mt-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700 font-medium">
                            Avoid Copying Vendor Folders
                        </p>
                        <p class="text-sm text-yellow-600 mt-1">
                            Please avoid copying the <code>vendor</code> folder from other web applications, as package and framework version mismatch will cause fatal runtime errors.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-400">
                NuvisAccounting &copy; <?php echo date('Y'); ?>. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
            <?php
            exit(1);
        }
    }
}

$vendor_autoload = __DIR__ . '/../vendor/autoload.php';

if (!file_exists($vendor_autoload)) {
    show_missing_dependencies_error();
}

// Load composer for core
require $vendor_autoload;

if (!class_exists(\Illuminate\Foundation\Application::class)) {
    show_missing_dependencies_error();
}
