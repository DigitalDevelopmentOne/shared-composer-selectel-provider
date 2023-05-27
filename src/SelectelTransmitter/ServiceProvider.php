<?php

namespace SelectelTransmitter;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{

    public function register()
    {
        $app = $this->app;

        $app->singleton(Transmitter::class, function ($app) {
            return new Transmitter(
                config('selecteltransmitter.user'),
                config('selecteltransmitter.password'),
                config('selecteltransmitter.container'),
                config('selecteltransmitter.account')
            );
        });
    }

    public function boot()
    {
        $configPath = __DIR__.'/../config/selecteltransmitter.php';
        $this->publishes([
            $configPath => config_path('selecteltransmitter.php'),
        ], 'config');
    }

    public function provides()
    {
        return [
            Transmitter::class
        ];
    }


}
