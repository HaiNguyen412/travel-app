<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\Enums\Department as EnumsDepartment;
use App\Repositories\IRepositories\IDepartmentRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

class DepartmentRepository extends AbstractRepository implements IDepartmentRepository
{
    public function __construct(Department $department)
    {
        parent::__construct($department);
    }

    public function paginate(Request $request)
    {
        return $this->query()->when($request->keyword, function (Builder $query) use ($request) {
            $query->where('name', 'like', '%'.$request->keyword.'%');
        })->paginate($request->limit);
    }

    public function get()
    {
        return $this->query()->active()->get();
    }
}
