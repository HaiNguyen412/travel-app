<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Services\IServices\IDepartmentService;
use App\Http\Requests\BaseIndexRequest;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use Illuminate\Support\Facades\Response;

class DepartmentController extends Controller
{
    private $departmentService;
    public function __construct(IDepartmentService $departmentService)
    {
        $this->middleware(['jwt.auth']);
        $this->departmentService = $departmentService;
        $this->authorizeResource(Department::class, 'department');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function index(BaseIndexRequest $request)
    {
        return DepartmentResource::collection(
            $this->departmentService->paginate($request)
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartmentRequest $request)
    {
        return Response::storeSuccess(
            $this->departmentService->create($request)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        return Response::showSuccess(
            DepartmentResource::make($department)
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        return Response:: updateSuccess(
            $this->departmentService->update($department->id, $request),
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        return Response:: deleteSuccess(
            $this->departmentService->delete($department->id)
        );
    }

    public function list()
    {
        $this->authorize('list', Department::class);
        return DepartmentResource::collection(
            $this->departmentService->get()
        );
    }
}
