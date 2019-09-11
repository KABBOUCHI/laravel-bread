<?php

namespace KABBOUCHI\Bread;

use Illuminate\Support\ServiceProvider;

class BreadServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerResources();
    }

    private function registerResources()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'bread');

        $this->publishes([
            __DIR__.'/../config/bread.php' => config_path('bread.php'),
        ], 'bread');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/bread'),
        ], 'bread');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/bread.php',
            'bread'
        );

        $this->registerCommands();
    }

    private function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\BreadMakeCommand::class,
            ]);
        }
    }
}
