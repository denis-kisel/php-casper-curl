<?php

namespace DenisKisel\CasperCurl;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/../config/casper_curl.php';

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'casper_curl');
        $this->publishes([
            self::CONFIG_PATH => config_path('casper_curl.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            self::CONFIG_PATH,
            'casper_curl'
        );
    }
}
