<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use InfluxDB\Client;

class InfluxServiceProvider extends ServiceProvider
{
    public $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('influx', function ($app) {
            $client = new Client(
                env("INFLUX_DB_HOST"),
                env("INFLUX_DB_PORT"),
                env("INFLUX_DB_USERNAME"),
                env("INFLUX_DB_PASSWORD")
            );

            return $client;
        });

        $this->app->singleton('influxdb', function ($app) {
            $db = app('influx')->selectDB(env("INFLUX_DB_NAME"));

            return $db;
        });
    }
}
