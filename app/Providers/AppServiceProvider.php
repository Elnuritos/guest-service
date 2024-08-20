<?php

namespace App\Providers;

use Monolog\Handler\RedisHandler;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redis;
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
        $this->app->singleton('redis-logging-handler', function () {
            return new RedisHandler(Redis::connection()->client(), env('REDIS_LOG_KEY', 'logs'), env('REDIS_LOG_CAP_SIZE', 1000));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::addNamespace('swagger-l5', resource_path('views/vendor/l5-swagger'));
    }
}
