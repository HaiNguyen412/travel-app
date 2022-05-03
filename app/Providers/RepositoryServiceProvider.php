<?php

namespace App\Providers;

use App\Repositories\IRepositories\IRoleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\IRepositories\ICategoryRepository;
use App\Services\IServices\IUserService;
use App\Repositories\IRepositories\IUserRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Services\IServices\IRoleService;
use App\Services\RoleService;
use App\Services\CategoryService;
use App\Services\IServices\ICategoryService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IUserService::class, UserService::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IRoleService::class, RoleService::class);
        $this->app->bind(IRoleRepository::class, RoleRepository::class);
        $this->app->bind(ICategoryRepository::class, CategoryRepository::class);
        $this->app->bind(ICategoryService::class, CategoryService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
