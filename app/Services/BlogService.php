<?php

namespace App\Services;

use App\Models\Blog;
use App\Services\IServices\IBlogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogService extends AbstractService implements IBlogService
{
    public function __construct(Blog $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, $limit = 10)
    {
        return $this->query()->when($request->name, function ($query, $name) {
            return $query->search('name', $name);
        })->paginate($limit);
    }

    public function create(Request $request)
    {
        return $this->query()->create($request->validated());
    }

    public function like(Request $request)
    {
        if ($request->like == 1) {
            return Blog::findOrFail($request->id)->increment('like_total', 1);
        } else {
            return Blog::findOrFail($request->id)->decrement('like_total', 1);
        }
    }

    public function dislike(Request $request)
    {
        if ($request->dislike == 1) {
            return Blog::findOrFail($request->id)->increment('like_total', 1);
        } else {
            return Blog::findOrFail($request->id)->decrement('like_total', 1);
        }
    }

    public function update($id, Request $request)
    {
        return $this->query()->findOrFail($id)->update($request->validated());
    }

    public function delete($id)
    {
        return $this->query()->findOrFail($id)->delete();
    }
}
