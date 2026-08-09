<?php

namespace App\Http\Controllers\Install;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class RepoUpdates extends Controller
{
    /**
     * Run the repository pull and update commands.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function pull(Request $request)
    {
        // Restrict to admins (already handled by admin middleware if placed under admin prefix,
        // but we can also perform an additional check here for extra security)
        if (auth()->check() && !auth()->user()->can('read-install-updates')) {
            return response()->json([
                'success' => false,
                'error' => true,
                'message' => 'Unauthorized access. Administrator permissions required.',
            ], 403);
        }

        set_time_limit(900); // 15 minutes limit

        $logPath = storage_path('logs/repo_updates.log');
        $output = [];

        // Log initiation
        $this->appendLog($logPath, "--- UPDATE INITIATED AT " . date('Y-m-d H:i:s') . " ---");

        // Commands to execute
        $commands = [
            'Git Checkout' => 'git checkout -- . 2>&1',
            'Git Pull'     => 'git pull origin main 2>&1',
            'Config Clear' => 'php artisan config:clear 2>&1',
            'Cache Clear'  => 'php artisan cache:clear 2>&1',
            'View Clear'   => 'php artisan view:clear 2>&1',
            'Route Clear'  => 'php artisan route:clear 2>&1',
            'Migrate'      => 'php artisan migrate --force 2>&1'
        ];

        $success = true;
        foreach ($commands as $name => $cmd) {
            $this->appendLog($logPath, "[Executing: {$name}] $ {$cmd}");

            exec($cmd, $cmdOutput, $resultCode);

            $outputStr = implode("\n", $cmdOutput);
            $this->appendLog($logPath, $outputStr);
            $this->appendLog($logPath, "[Finished: {$name}] Result Code: {$resultCode}\n");

            $output[] = [
                'name' => $name,
                'command' => $cmd,
                'output' => $outputStr,
                'code' => $resultCode
            ];

            // If Git checkout, pull, or migrate fails, log and handle, but keep going for clears
            if ($resultCode !== 0 && in_array($name, ['Git Pull', 'Migrate'])) {
                $success = false;
            }

            // Clear buffer for next command
            unset($cmdOutput);
            $cmdOutput = [];
        }

        $this->appendLog($logPath, "--- UPDATE FINISHED. SUCCESS Status: " . ($success ? "YES" : "NO") . " ---\n\n");

        return response()->json([
            'success' => $success,
            'error' => !$success,
            'data' => $output,
            'message' => $success ? 'System updated successfully from repository.' : 'An error occurred during repository update.'
        ]);
    }

    /**
     * Get the repository update logs.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logs()
    {
        $logPath = storage_path('logs/repo_updates.log');
        $content = '';
        if (File::exists($logPath)) {
            $content = File::get($logPath);
        }

        return response()->json([
            'success' => true,
            'logs' => $content
        ]);
    }

    /**
     * Clear the repository update logs.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function clearLogs()
    {
        $logPath = storage_path('logs/repo_updates.log');
        if (File::exists($logPath)) {
            File::put($logPath, '');
        }

        return response()->json([
            'success' => true,
            'message' => 'Logs cleared.'
        ]);
    }

    /**
     * Append message to update log file.
     *
     * @param string $path
     * @param string $message
     */
    private function appendLog($path, $message)
    {
        File::append($path, $message . "\n");
    }
}
