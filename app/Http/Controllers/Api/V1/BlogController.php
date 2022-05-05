<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\Blog\BlogCreateRequest;
use App\Http\Requests\Common\Blog\BlogUpdateRequest;
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

    public function store(BlogCreateRequest $request) {
        return Response::storeSuccess($this->blogService->create($request));
    }

    public function update(int $id, BlogUpdateRequest $request)
    {
        return Response::updateSuccess($this->blogService->update($id, $request));
    }

    public function destroy($id)
    {
        return Response::deleteSuccess(
            $this->blogService->delete($id)
        );
    }

    public function like(Request $request)
    {
        return Response::updateSuccess(
            $this->blogService->like($request)
        );
    }

    public function dislike(Request $request)
    {
        return Response::updateSuccess(
            $this->blogService->dislike($request)
        );
    }
}
