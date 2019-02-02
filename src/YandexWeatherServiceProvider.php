<?php

namespace Grechanyuk\YandexWeather;

use Illuminate\Support\ServiceProvider;

class YandexWeatherServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'grechanyuk');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'grechanyuk');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/yandexweather.php', 'yandexweather');

        // Register the service the package provides.
        $this->app->singleton('yandexweather', function ($app) {
            return new YandexWeather;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['yandexweather'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/yandexweather.php' => config_path('yandexweather.php'),
        ], 'yandexweather.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/grechanyuk'),
        ], 'yandexweather.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/grechanyuk'),
        ], 'yandexweather.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/grechanyuk'),
        ], 'yandexweather.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
