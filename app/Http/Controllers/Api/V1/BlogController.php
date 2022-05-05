<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Services\IServices\IBlogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BlogController extends Controller
{
    protected $blogService;

    public function __construct(IBlogService $blogService)
    {
        return $this->blogService = $blogService;
    }

    public function index(Request $request)
    {
        return BlogResource::collection(
            $this->blogService->index($request)
        );
    }

    public function store(Request $request)
    {
        return Response::storeSuccess(
            $this->blogService->create($request)
        );
    }

    public function update(Request $request, $id)
    {
        return Response::updateSuccess(
            $this->blogService->update($request, $id)
        );
    }

    public function destroy($id)
    {
        return Response::deleteSuccess(
            $this->blogService->delete($id)
        );
    }

    public function like(Request $request, $id)
    {
        return Response::updateSuccess(
            $this->blogService->like($request, $id)
        );
    }

    public function dislike(Request $request, $id)
    {
        return Response::updateSuccess(
            $this->blogService->dislike($request, $id)
        );
    }
}
