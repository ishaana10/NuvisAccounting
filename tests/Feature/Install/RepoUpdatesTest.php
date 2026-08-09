<?php

namespace Tests\Feature\Install;

use Tests\Feature\FeatureTestCase;
use Illuminate\Support\Facades\File;

class RepoUpdatesTest extends FeatureTestCase
{
    public function testItShouldPreventUnauthorizedUserFromPulling()
    {
        // Unauthenticated users should be redirected or unauthorized
        $this->post(route('updates.repo-pull'))
            ->assertStatus(302); // Redirect to login
    }

    public function testItShouldPreventUnauthorizedUserFromReadingLogs()
    {
        $this->get(route('updates.repo-logs'))
            ->assertStatus(302); // Redirect to login
    }

    public function testItShouldClearLogs()
    {
        $logPath = storage_path('logs/repo_updates.log');
        File::put($logPath, 'Some dummy log output');

        $this->loginAs()
            ->post(route('updates.repo-clear-logs'))
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Logs cleared.'
            ]);

        $this->assertTrue(File::exists($logPath));
        $this->assertEquals('', File::get($logPath));
    }

    public function testItShouldReadLogs()
    {
        $logPath = storage_path('logs/repo_updates.log');
        File::put($logPath, 'Repo update log content test');

        $this->loginAs()
            ->get(route('updates.repo-logs'))
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'logs' => 'Repo update log content test'
            ]);
    }
}
