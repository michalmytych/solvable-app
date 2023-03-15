<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\SolutionRepository;
use App\Repositories\CodeLanguageRepository;
use App\Contracts\Repositories\SolutionRepositoryInterface;
use App\Contracts\Repositories\CodeLanguageRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(SolutionRepositoryInterface::class, SolutionRepository::class);
        $this->app->bind(CodeLanguageRepositoryInterface::class, CodeLanguageRepository::class);
    }
}
