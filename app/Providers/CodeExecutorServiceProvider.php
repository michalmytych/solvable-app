<?php

namespace App\Providers;

use App\Contracts\CodeExecutor\CodeExecutorServiceInterface;
use App\Services\CodeExecutor\CodeExecutorService;
use Illuminate\Support\ServiceProvider;

class CodeExecutorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(CodeExecutorServiceInterface::class, CodeExecutorService::class);
    }
}
