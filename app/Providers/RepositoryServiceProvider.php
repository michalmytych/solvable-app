<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Repositories\GroupRepository;
use App\Repositories\CourseRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ProblemRepository;
use App\Repositories\SolutionRepository;
use App\Repositories\CodeLanguageRepository;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Repositories\GroupRepositoryInterface;
use App\Contracts\Repositories\CourseRepositoryInterface;
use App\Contracts\Repositories\ProblemRepositoryInterface;
use App\Contracts\Repositories\SolutionRepositoryInterface;
use App\Contracts\Repositories\CodeLanguageRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        UserRepositoryInterface::class         => UserRepository::class,
        SolutionRepositoryInterface::class     => SolutionRepository::class,
        CodeLanguageRepositoryInterface::class => CodeLanguageRepository::class,
        GroupRepositoryInterface::class        => GroupRepository::class,
        CourseRepositoryInterface::class       => CourseRepository::class,
        ProblemRepositoryInterface::class      => ProblemRepository::class,
    ];
}
