<?php

namespace Alliance\LaravelEmailTemplate;

use Illuminate\Support\ServiceProvider;

class LaravelEmailTemplateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravelemailtemplate');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->publishes([
            __DIR__.'/config/laravelemailtemplate.php' => config_path('laravelemailtemplate.php'),
        ], 'laravelemailtemplate.config');

        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/alliance'),
        ], 'laravelemailtemplate.views');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/laravelemailtemplate.php', 'laravelemailtemplate');
    }
}
