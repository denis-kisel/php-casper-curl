<?php

namespace DenisKisel\CasperCurl;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/../config/phantom_curl.php';

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'phantom_curl');
        $this->publishes([
            self::CONFIG_PATH => config_path('phantom_curl.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            self::CONFIG_PATH,
            'phantom_curl'
        );
    }
}
