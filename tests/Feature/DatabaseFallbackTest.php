<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class DatabaseFallbackTest extends TestCase
{
    public function test_it_loads_data_from_json_when_db_is_offline()
    {
        // 1. Simulate DB offline
        Config::set('app.db_offline', true);

        // 2. Fetch users
        $users = User::all();

        // 3. Verify data comes from JSON
        $this->assertNotEmpty($users);
        $this->assertEquals('admin', $users->first()->username);

        // Check if it's the mock data we expect
        $fallbackData = json_decode(File::get(database_path('fallback_data.json')), true);
        $this->assertEquals($fallbackData['users'][0]['name'], $users->first()->name);
    }

    public function test_it_shows_admin_password_alert_when_db_is_offline()
    {
        // 1. Simulate DB offline
        Config::set('app.db_offline', true);

        // 2. Visit home page (assuming it's a guest or auth doesn't block it for this test)
        // We might need to act as a user, but since User::all() is fallback, auth might work!
        $response = $this->get('/');

        // 3. Verify alert is visible
        $response->assertSee('Database Offline');
        $response->assertSee('Default Admin Password:');
        $response->assertSee('password');
    }
}
