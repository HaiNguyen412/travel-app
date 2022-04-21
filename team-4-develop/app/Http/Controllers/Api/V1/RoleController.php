<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BaseIndexRequest;
use App\Http\Resources\RoleResource;
use App\Services\IServices\IRoleService;

class RoleController extends Controller
{
    private $roleService;

    public function __construct(IRoleService $roleService)
    {
        $this->middleware(['jwt.auth']);
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RoleResource::collection(
            $this->roleService->get()
        );
    }
}
