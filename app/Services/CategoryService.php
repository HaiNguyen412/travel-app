<?php

namespace App\Services;

use App\Models\Category;
use App\Services\IServices\ICategoryService;
use Illuminate\Http\Request;

class CategoryService implements ICategoryService
{
    public function index(Request $request)
    {
        $params = $request->all();
        $results = Category::when(isset($params['params']), function ($query) use ($params) {
                return $query->where('categories.name', 'like', '%' . $params['params'] . '%');
            })
            ->paginate($request->limit);
        if (isset($params['params'])) {
            $results->appends(['params' => $params['params']]);
        }
        return $results;
        // return Category::paginate(5);
    }

    public function store(Request $request)
    {
        $category = $request->all();
        return Category::create($category);
    }

    public function delete($id)
    {
        return Category::findOrFail($id)->delete();
    }

    public function update(Request $request, $id)
    {
        $category = $request->all();
        return Category::findOrFail($id)->update($category);
    }
}
