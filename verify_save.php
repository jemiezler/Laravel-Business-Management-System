<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Config;

Config::set('app.db_offline', true);
echo "DB Offline: " . (Config::get('app.db_offline') ? 'true' : 'false') . "\n";

$user = User::where('username', 'admin')->first();
if ($user) {
    echo "User found: " . $user->username . "\n";
    echo "Attempting to save user...\n";
    $user->save();
    echo "Save successful!\n";
} else {
    echo "User NOT found!\n";
}

echo "Testing aggregates...\n";
$employeeCount = \App\Models\Employee::count();
echo "Total employees: " . $employeeCount . "\n";
