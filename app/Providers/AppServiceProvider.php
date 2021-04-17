<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Artisan::call('migrate', ['--force' => true, '--path' => '/database/migrations/2021_04_17_094446_create_settings_table.php']);
        $this->app->singleton(Setting::class, function () {
            return Setting::first();
        });
        config(['app.settings' => app()->make(Setting::class)]);
        Paginator::useBootstrap();
    }
}
