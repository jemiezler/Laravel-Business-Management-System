<?php
require __DIR__ . '/vendor/autoload.php';

// Mock database_path so it doesn't try to use Laravel's
function database_path($path = '')
{
    return __DIR__ . '/database/' . $path;
}

// 1. Define things that JsonOnlyBuilder needs
use App\Models\User;
use App\Builders\JsonOnlyBuilder;
use Illuminate\Support\Facades\Config;

// We need to mock Config facade OR just ensure the trait uses it safely
// Actually the trait uses Config::get. We can mock it.
// But for this test, we can just instantiate the builder directly.

echo "1. Creating Model instance...\n";
// We need a model, but we don't want to boot Laravel.
// We can use a simple class that extends Model but doesn't do much.
class SimpleModel extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'users';
}

$model = new SimpleModel();
echo "2. Instantiating JsonOnlyBuilder...\n";
try {
    $builder = new JsonOnlyBuilder($model);
    echo "Builder instantiated!\n";

    echo "3. Testing where()...\n";
    $builder->where('username', 'admin');

    echo "4. Testing get()...\n";
    $results = $builder->get();

    echo "Results count: " . $results->count() . "\n";
    if ($results->count() > 0) {
        echo "First user: " . $results->first()->username . "\n";
    }

    echo "5. Testing paginate()...\n";
    $paginator = $builder->paginate(1);
    echo "Paginator total: " . $paginator->total() . "\n";
    echo "Paginator count: " . $paginator->count() . "\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

echo "\nDone isolated test.\n";
