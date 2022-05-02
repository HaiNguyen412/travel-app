<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Services\IServices\ICategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(ICategoryService $categoryService)
    {
        return $this->categoryService = $categoryService;
    }
    public function index(Request $request)
    {
        return CategoryResource::collection($this->categoryService->index($request));
    }

    public function store(Request $request)
    {
        return Response::storeSuccess($this->categoryService->store($request));
    }

    public function destroy($id) {
        return Response::deleteSuccess($this->categoryService->delete($id));
    }

    public function update(Request $request, $id) {
        return Response::updateSuccess($this->categoryService->update($request, $id));
    }
}
