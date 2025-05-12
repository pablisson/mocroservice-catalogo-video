<?php

namespace App\Providers;

use App\Repositories\Eloquent\CategoryRepository;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
		$this->app->singleton(CategoryRepositoryInterface::class, CategoryRepository::class);
		$this->app->singleton(ExceptionHandler::class, \App\Exceptions\Handler::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
