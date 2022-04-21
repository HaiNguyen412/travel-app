<?php

namespace App\Providers;

use App\Repositories\IRepositories\IPositionRepository;
use App\Repositories\IRepositories\IRequestRepository;
use App\Repositories\IRepositories\IRoleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\IRepositories\ICategoryRepository;
use App\Repositories\IRepositories\IPriorityRepository;
use App\Repositories\PriorityRepository;
use App\Services\IServices\IPriorityService;
use App\Repositories\DepartmentRepository;
use App\Repositories\IRepositories\ICommentRepository;
use App\Repositories\IRepositories\IDepartmentRepository;
use App\Services\IServices\IUserService;
use App\Repositories\IRepositories\IUserRepository;
use App\Repositories\PositionRepository;
use App\Repositories\RequestRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Services\IServices\IPositionService;
use App\Services\IServices\IRequestService;
use App\Services\IServices\IRoleService;
use App\Services\PositionService;
use App\Services\RequestService;
use App\Services\PriorityService;
use App\Services\RoleService;
use App\Services\CategoryService;
use App\Services\CommentService;
use App\Services\IServices\ICategoryService;
use App\Services\DepartmentService;
use App\Services\IServices\ICommentService;
use App\Services\IServices\IDepartmentService;
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
        $this->app->bind(IPositionService::class, PositionService::class);
        $this->app->bind(IPriorityService::class, PriorityService::class);
        $this->app->bind(IPositionRepository::class, PositionRepository::class);
        $this->app->bind(ICategoryService::class, CategoryService::class);
        $this->app->bind(ICategoryRepository::class, CategoryRepository::class);
        $this->app->bind(IRequestService::class, RequestService::class);
        $this->app->bind(IRequestRepository::class, RequestRepository::class);
        $this->app->bind(IPriorityRepository::class, PriorityRepository::class);
        $this->app->bind(IDepartmentService::class, DepartmentService::class);
        $this->app->bind(IDepartmentRepository::class, DepartmentRepository::class);
        $this->app->bind(ICommentService::class, CommentService::class);
        $this->app->bind(ICommentRepository::class, CommentRepository::class);
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
