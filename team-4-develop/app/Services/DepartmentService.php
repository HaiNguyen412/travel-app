<?php

namespace App\Services;

use App\Services\IServices\IDepartmentService;
use App\Repositories\IRepositories\IDepartmentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DepartmentService extends AbstractService implements IDepartmentService
{
    public function __construct(IDepartmentRepository $departmentRepository)
    {
        parent::__construct($departmentRepository);
    }

    public function paginate(Request $request)
    {
        return $this->repository->paginate($request);
    }

    public function get()
    {
        return Cache::rememberForever('departments', function () {
            return $this->repository->get();
        });
    }

    public function create(Request $request)
    {
        $department = $this->repository->create($request->validated());
        Cache::forget('departments');
        Cache::rememberForever('departments', function () {
            return $this->repository->get();
        });
        return $department;
    }

    public function update(int $id, Request $request)
    {
        $department = $this->repository->update($id, $request->validated());
        Cache::forget('departments');
        Cache::rememberForever('departments', function () {
            return $this->repository->get();
        });
        return $department;
    }
}
