<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Support\ExternalCompiler\Client as ExternalCompilerClient;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ExternalCompilerClient::class, function ($app) {
            return new ExternalCompilerClient([
                'base_uri' => $app->config->get('services.external-compiler-client.uri'),
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'clientId' => config('services.external-compiler-client.client-id'),
                    'clientSecret' => config('services.external-compiler-client.client-secret'),
                ]
            ]);
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
