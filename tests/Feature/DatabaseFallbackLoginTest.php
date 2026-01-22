<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class DatabaseFallbackLoginTest extends TestCase
{
    public function test_it_can_login_when_db_is_offline()
    {
        echo "\nStarting test...";
        echo "\nEnvironment: " . app()->environment();

        // 1. Simulate DB offline
        Config::set('app.db_offline', true);
        echo "\nDB offline set to: " . (Config::get('app.db_offline') ? 'true' : 'false');
        echo "\nSession Driver: " . Config::get('session.driver');

        // 2. Attempt login as admin (password in JSON is 'password')
        echo "\nAttempting login...";
        try {
            $response = $this->post('/login', [
                '_token' => csrf_token(),
                'username' => 'admin',
                'password' => 'password',
            ]);
            echo "\nLogin attempt finished. Status: " . $response->getStatusCode();
        } catch (\Exception $e) {
            echo "\nException during login: " . $e->getMessage();
            throw $e;
        }

        // 3. Verify redirection to home (successful login)
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs(User::where('username', 'admin')->first());
    }
}
