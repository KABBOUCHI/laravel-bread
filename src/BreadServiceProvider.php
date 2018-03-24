<?php namespace KABBOUCHI\Bread;

use Illuminate\Routing\Route;
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
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    private function registerResources()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'bread');
    }

}