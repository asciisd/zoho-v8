<?php

namespace Asciisd\ZohoV8;

use Asciisd\ZohoV8\Console\ZohoAuthCommand;
use Asciisd\ZohoV8\Console\ZohoRefreshTokenCommand;
use Asciisd\ZohoV8\Console\ZohoSetupCommand;
use Asciisd\ZohoV8\Console\ZohoSyncCommand;
use Asciisd\ZohoV8\Console\ZohoTestCommand;
use Illuminate\Support\ServiceProvider;

class ZohoServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/zoho.php',
            'zoho'
        );

        $this->app->singleton('zoho', function ($app) {
            return new ZohoClient();
        });

        $this->app->singleton('zoho.oauth', function ($app) {
            return new Auth\OAuthManager();
        });

        $this->app->singleton('zoho.storage', function ($app) {
            return new Storage\TokenStorage();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Publish configuration
        $this->publishes([
            __DIR__.'/../config/zoho.php' => config_path('zoho.php'),
        ], 'zoho-config');

        // Publish migrations
        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'zoho-migrations');

        // Load routes
        $this->loadRoutesFrom(__DIR__.'/../routes/zoho.php');

        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                ZohoSetupCommand::class,
                ZohoAuthCommand::class,
                ZohoTestCommand::class,
                ZohoSyncCommand::class,
                ZohoRefreshTokenCommand::class,
            ]);
        }
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return ['zoho', 'zoho.oauth', 'zoho.storage'];
    }
}

