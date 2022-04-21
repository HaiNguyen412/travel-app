<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\IRepositories\IRoleRepository;
use Illuminate\Http\Request;

class RoleRepository extends AbstractRepository implements IRoleRepository
{
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }

    public function get()
    {
        return $this->query()->get();
    }
}
