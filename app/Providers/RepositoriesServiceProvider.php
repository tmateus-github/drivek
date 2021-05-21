<?php

namespace App\Providers;

use App\Repositories\ExternalUserRepository\ExternalUserRepository;
use App\Repositories\ExternalUserRepository\ExternalUserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ExternalUserRepositoryInterface::class, ExternalUserRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
