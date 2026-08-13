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
    function show_missing_dependencies_error($caught_exception = null) {
        // Run comprehensive diagnostic checks
        $diagnostics = run_diagnostics_checklist();

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
            $message .= "\033[31;1m============================================================\033[0m" . PHP_EOL;

            // Output caught exception
            if ($caught_exception) {
                $message .= "\033[33;1mUncaught Exception/Error:\033[0m" . PHP_EOL;
                $message .= "  " . get_class($caught_exception) . ": " . $caught_exception->getMessage() . PHP_EOL;
                $message .= "  File: " . $caught_exception->getFile() . ":" . $caught_exception->getLine() . PHP_EOL . PHP_EOL;
            }

            // Output diagnostics
            $message .= "\033[36;1mSystem & Dependency Diagnostic Checklist:\033[0m" . PHP_EOL;
            foreach ($diagnostics as $category => $items) {
                $message .= PHP_EOL . "  \033[35;1m[" . strtoupper($category) . "]\033[0m" . PHP_EOL;
                foreach ($items as $name => $info) {
                    $status = $info['passed'] ? "\033[32;1m[PASS]\033[0m" : "\033[31;1m[FAIL]\033[0m";
                    $message .= "    " . str_pad($name, 40, '.') . " " . $status;
                    if (!$info['passed'] && isset($info['error'])) {
                        $message .= " (\033[33m" . $info['error'] . "\033[0m)";
                    }
                    $message .= PHP_EOL;
                }
            }
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
    <div class="max-w-4xl w-full space-y-8 bg-white p-8 sm:p-10 rounded-2xl shadow-xl border border-gray-100">
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

            <?php if ($caught_exception): ?>
                <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-orange-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3 w-full">
                            <p class="text-sm text-orange-700 font-medium">
                                Uncaught PHP Exception / Error:
                            </p>
                            <div class="mt-2 text-sm text-orange-800 font-mono bg-orange-100 p-3 rounded overflow-x-auto">
                                <strong>Type:</strong> <?php echo get_class($caught_exception); ?><br>
                                <strong>Message:</strong> <?php echo htmlspecialchars($caught_exception->getMessage()); ?><br>
                                <strong>File:</strong> <?php echo htmlspecialchars($caught_exception->getFile()); ?>:<?php echo $caught_exception->getLine(); ?><br>
                            </div>
                            <details class="mt-2">
                                <summary class="text-xs text-orange-600 hover:text-orange-800 cursor-pointer select-none">Show stack trace</summary>
                                <pre class="mt-2 text-xs text-orange-700 font-mono bg-orange-100 p-3 rounded overflow-x-auto max-h-60"><?php echo htmlspecialchars($caught_exception->getTraceAsString()); ?></pre>
                            </details>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Interactive Diagnostics Section -->
            <div class="space-y-4 bg-gray-50 border border-gray-200 rounded-xl p-6">
                <h3 class="text-xl font-bold text-gray-900 flex items-center justify-between">
                    <span>System & Dependency Diagnostic Report</span>
                    <span class="text-xs font-normal text-gray-500 bg-gray-200 px-2 py-1 rounded">PHP v<?php echo PHP_VERSION; ?></span>
                </h3>
                <p class="text-sm text-gray-600">
                    Below is the status of PHP extensions, core directories, and required composer classes. Failed checks can pinpoint exactly what is missing or misconfigured in your deployment.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <?php foreach ($diagnostics as $category => $items): ?>
                        <div class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm">
                            <h4 class="font-bold text-gray-800 border-b pb-2 mb-3 flex justify-between items-center text-sm uppercase tracking-wider">
                                <span><?php echo htmlspecialchars($category); ?></span>
                                <span class="text-xs px-2 py-0.5 rounded-full <?php
                                    $category_failed = false;
                                    foreach ($items as $info) {
                                        if (!$info['passed']) { $category_failed = true; break; }
                                    }
                                    echo $category_failed ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700';
                                ?>">
                                    <?php echo $category_failed ? 'Issues Found' : 'All Passed'; ?>
                                </span>
                            </h4>
                            <ul class="space-y-2">
                                <?php foreach ($items as $name => $info): ?>
                                    <li class="flex items-start justify-between text-sm">
                                        <div class="flex-1">
                                            <span class="font-medium text-gray-700"><?php echo htmlspecialchars($name); ?></span>
                                            <?php if (!$info['passed'] && isset($info['error'])): ?>
                                                <p class="text-xs text-red-500 font-mono mt-0.5"><?php echo htmlspecialchars($info['error']); ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <span class="flex-shrink-0 ml-2">
                                            <?php if ($info['passed']): ?>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    ✓ Pass
                                                </span>
                                            <?php else: ?>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    ✗ Fail
                                                </span>
                                            <?php endif; ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
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

if (!function_exists('run_diagnostics_checklist')) {
    function run_diagnostics_checklist() {
        $checklist = [
            'php_extensions' => [],
            'writable_paths' => [],
            'vendor_existence' => [],
            'framework_classes' => [],
            'override_modules' => [],
        ];

        // 1. PHP Extensions
        $required_extensions = [
            'bcmath', 'ctype', 'curl', 'dom', 'fileinfo', 'gd', 'intl', 'json', 'mbstring',
            'openssl', 'tokenizer', 'xml', 'zip', 'pdo', 'pdo_mysql'
        ];
        foreach ($required_extensions as $ext) {
            $checklist['php_extensions'][$ext] = [
                'passed' => extension_loaded($ext),
                'error' => extension_loaded($ext) ? null : "PHP Extension '$ext' is not loaded or installed."
            ];
        }

        // 2. Critical Writable Paths
        $root = __DIR__ . '/..';
        $writable_paths = [
            'storage' => $root . '/storage',
            'storage/app' => $root . '/storage/app',
            'storage/framework' => $root . '/storage/framework',
            'storage/framework/cache' => $root . '/storage/framework/cache',
            'storage/framework/sessions' => $root . '/storage/framework/sessions',
            'storage/framework/views' => $root . '/storage/framework/views',
            'storage/logs' => $root . '/storage/logs',
            'bootstrap/cache' => $root . '/bootstrap/cache',
        ];
        foreach ($writable_paths as $name => $path) {
            $exists = file_exists($path);
            $is_writable = $exists && is_writable($path);
            $error = null;
            if (!$exists) {
                $error = "Directory does not exist.";
            } elseif (!$is_writable) {
                $error = "Directory exists but is not writable. Check folder permissions (e.g., chmod 775 or 755).";
            }
            $checklist['writable_paths'][$name] = [
                'passed' => $is_writable,
                'error' => $error
            ];
        }

        // 3. Autoload Existence
        $autoload_file = $root . '/vendor/autoload.php';
        $checklist['vendor_existence']['vendor/autoload.php'] = [
            'passed' => file_exists($autoload_file),
            'error' => file_exists($autoload_file) ? null : "The 'vendor/autoload.php' file is missing. Please run 'composer install'."
        ];

        // 4. Core Framework Classes (only checked if autoload exists)
        $core_classes = [
            'Illuminate\Foundation\Application' => 'laravel/framework',
            'Livewire\Livewire' => 'livewire/livewire',
            'Laratrust\Laratrust' => 'santigarcor/laratrust',
            'Sentry\Laravel\ServiceProvider' => 'sentry/sentry-laravel',
            'Intervention\Image\ImageServiceProvider' => 'intervention/image',
            'Barryvdh\DomPDF\ServiceProvider' => 'barryvdh/laravel-dompdf',
            'Maatwebsite\Excel\ExcelServiceProvider' => 'maatwebsite/excel',
            'Plank\Mediable\MediableServiceProvider' => 'plank/laravel-mediable',
        ];
        foreach ($core_classes as $class => $package) {
            if (!file_exists($autoload_file)) {
                $checklist['framework_classes'][$class] = [
                    'passed' => false,
                    'error' => "Cannot check; 'vendor/autoload.php' is missing."
                ];
            } else {
                $passed = class_exists($class) || interface_exists($class) || trait_exists($class);
                $checklist['framework_classes'][$class] = [
                    'passed' => $passed,
                    'error' => $passed ? null : "Class/interface '$class' is missing from '$package'. The package might be missing or incomplete."
                ];
            }
        }

        // 5. Override Modules
        $override_namespaces = [
            'NuvisAccounting\Apexcharts\Chart' => 'overrides/nuvisaccounting/laravel-apexcharts',
            'NuvisAccounting\Module\Commands\DisableCommand' => 'overrides/nuvisaccounting/laravel-module',
        ];
        foreach ($override_namespaces as $class => $path) {
            if (!file_exists($autoload_file)) {
                $checklist['override_modules'][$class] = [
                    'passed' => false,
                    'error' => "Cannot check; 'vendor/autoload.php' is missing."
                ];
            } else {
                $passed = class_exists($class) || interface_exists($class) || trait_exists($class);
                $checklist['override_modules'][$class] = [
                    'passed' => $passed,
                    'error' => $passed ? null : "Autoload mapping for '$class' from directory '$path' failed. Check override composer settings."
                ];
            }
        }

        return $checklist;
    }
}

try {
    $vendor_autoload = __DIR__ . '/../vendor/autoload.php';

    if (!file_exists($vendor_autoload)) {
        show_missing_dependencies_error();
    }

    // Load composer for core
    require $vendor_autoload;

    if (!class_exists(\Illuminate\Foundation\Application::class)) {
        show_missing_dependencies_error();
    }
} catch (Throwable $t) {
    // Catch any syntax, version incompatibility, or runtime errors during bootstrap loading
    show_missing_dependencies_error($t);
}
