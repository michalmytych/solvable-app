<?php

namespace App\Providers;

use App\Contracts\SolutionRepositoryInterface;
use App\Repositories\SolutionRepository;
use Illuminate\Support\ServiceProvider;

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
    }
}
