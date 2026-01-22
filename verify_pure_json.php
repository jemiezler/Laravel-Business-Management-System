<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

// 1. Force offline
Config::set('app.db_offline', true);

echo "DB Offline: " . (Config::get('app.db_offline') ? 'true' : 'false') . "\n";

try {
    echo "\nTesting Login-like query...\n";
    $user = User::where('username', 'admin')->first();
    if ($user) {
        echo "User found: " . $user->username . "\n";
        echo "User class: " . get_class($user) . "\n";
    } else {
        echo "User NOT found!\n";
    }

    echo "\nTesting Dashboard stats...\n";
    $totalEmployees = Employee::count();
    $activeEmployees = Employee::where('status', 'active')->count();

    echo "Total employees: " . $totalEmployees . "\n";
    echo "Active employees: " . $activeEmployees . "\n";

    echo "\nTesting save() override...\n";
    if ($user) {
        $user->save();
        echo "Save called successfully (mocked).\n";
    }

    echo "\nVerification successful! No database connection was required.\n";
} catch (\Exception $e) {
    echo "\nERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
