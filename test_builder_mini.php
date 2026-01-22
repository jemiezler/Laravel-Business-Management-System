<?php
require __DIR__ . '/vendor/autoload.php';

echo "0. Booting bootstrap/app.php...\n";
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Config;

echo "1. Forcing offline...\n";
Config::set('app.db_offline', true);

// Mock database_path if needed (Laravel should have it if booted)
echo "2. Testing User::query() fallback...\n";
try {
    $query = User::query();
    echo "Query type: " . get_class($query) . "\n";

    echo "3. Testing where()...\n";
    $query->where('username', 'admin');

    echo "4. Testing first()...\n";
    $user = $query->first();

    if ($user) {
        echo "User found: " . $user->username . "\n";
    } else {
        echo "User NOT found!\n";
    }
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
echo "\nDone.\n";
