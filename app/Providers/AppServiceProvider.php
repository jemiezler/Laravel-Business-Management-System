<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->checkDatabaseConnection();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
    }

    protected function checkDatabaseConnection(): void
    {
        // Don't block console or tests
        if (app()->runningInConsole() || app()->environment('testing') || config('app.db_offline')) {
            return;
        }

        try {
            // Use a short timeout to prevent long hangs if the DB is completely down
            config(['database.connections.mysql.options.' . \PDO::ATTR_TIMEOUT => 2]);
            DB::connection()->getPdo();
            config(['app.db_offline' => false]);
        } catch (\Exception $e) {
            config([
                'app.db_offline' => true,
                'session.driver' => 'file',
                'cache.default' => 'file',
            ]);
        }
    }

    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(
            fn(): ?Password => app()->isProduction()
                ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
                : null
        );
    }
}
