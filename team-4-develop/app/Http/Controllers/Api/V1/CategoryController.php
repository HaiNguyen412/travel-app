<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\BaseIndexRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Policies\CategoryPolicy;
use App\Services\IServices\ICategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{
    private $CategoryService;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(ICategoryService $CategoryService)
    {
        $this->middleware(['jwt.auth']);
        $this->CategoryService = $CategoryService;
        $this->authorizeResource(Category::class);
    }
    public function index(BaseIndexRequest $request)
    {
        return CategoryResource::collection(
            $this->CategoryService->paginate($request)
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
    public function store(StoreCategoryRequest $request)
    {
        return Response::storeSuccess(
            $this->CategoryService->create($request)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return Response::showSuccess(
            CategoryResource::make($category->load('user'))
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
    public function update(Category $category, UpdateCategoryRequest $request)
    {
        return Response::updateSuccess(
            $this->CategoryService->update($category->id, $request)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        return Response::deleteSuccess(
            $this->CategoryService->delete($category->id)
        );
    }

    public function list()
    {
        return CategoryResource::collection(
            $this->CategoryService->get()
        );
    }
}
