<?php

namespace eDoctor\Phpecs;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Redis as Redis;

class PhpecsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/config.php' => config_path('phpecs.php')], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'phpecs');
        $this->app->singleton('eDoctor\Phpecs\Phpecs', function ($app) {
            return new Phpecs($app->config->get('phpecs'), Redis::connection());
        });
    }
}
