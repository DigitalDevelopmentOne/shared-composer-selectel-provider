<?php

namespace SelectelTransmitter;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class PasswordServiceProvider
 */
class ServiceProvider extends BaseServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        $app->singleton(Transmitter::class, function ($app) {
            $value = env(config('selecteltransmitter.user') ?? '-');
            return new Transmitter($value);
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
