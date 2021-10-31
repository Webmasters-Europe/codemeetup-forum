<?php

namespace App\Providers;

use App\Models\Setting;
use Database\Seeders\SettingsSeeder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Artisan::call('migrate', ['--force' => true, '--path' => '/database/migrations/2021_04_17_094446_create_settings_table.php']);
        if (Setting::exists() == false) {
            $seeder = new SettingsSeeder();
            $seeder->run();
        }
        $this->app->singleton(Setting::class, function () {
            return Setting::first();
        });
        config(['app.settings' => app()->make(Setting::class)]);
        Paginator::useBootstrap();
    }
}
