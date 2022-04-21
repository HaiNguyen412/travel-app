<?php

namespace App\Services;

use App\Services\IServices\IRoleService;
use App\Repositories\IRepositories\IRoleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RoleService extends AbstractService implements IRoleService
{

    public function __construct(IRoleRepository $roleRepository)
    {
        parent::__construct($roleRepository);
    }

    public function get()
    {
        return Cache::rememberForever('roles', function () {
            return $this->repository->get();
        });
    }
}
