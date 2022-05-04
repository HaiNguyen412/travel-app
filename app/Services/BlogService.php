<?php

namespace App\Services;

use App\Models\Blog;
use App\Services\IServices\IBlogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogService implements IBlogService
{
    public function index(Request $request)
    {
        $params = $request->all();
        $results = Blog::when(isset($params['params']), function ($query) use ($params) {
            return $query->where('blogs.name', 'like', '%' . $params['params'] . '%');
        })
            ->paginate($request->limit);
        if (isset($params['params'])) {
            $results->appends(['params' => $params['params']]);
        }
        return $results;
    }

    public function create(Request $request) {
        $blog = $request->all();
        return Blog::create($blog);
    }

    public function like(Request $request, $id)
    {
        $id = $request->id;
        $params = $request->like;
        if ($params == 1) {
            return Blog::where('id', $id)->update([
                'like_total' => DB::raw('like_total+1')
            ]);
        } else {
            return Blog::where('id', $id)->update([
                'like_total' => DB::raw('like_total-1')
            ]);
        }
    }

    public function dislike(Request $request, $id)
    {
        $id = $request->id;
        $params = $request->dislike;
        if ($params == 1) {
            return Blog::where('id', $id)->update([
                'dislike_total' => DB::raw('dislike_total+1')
            ]);
        } else {
            return Blog::where('id', $id)->update([
                'dislike_total' => DB::raw('dislike_total-1')
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $blog = $request->all();
        return Blog::findOrFail($id)->update($blog);
    }

    public function delete($id)
    {
        return Blog::findOrFail($id)->delete();
    }
}
