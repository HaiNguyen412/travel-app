<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Enums\Category as EnumsCategory;
use App\Repositories\IRepositories\ICategoryRepository;
use Illuminate\Http\Request;

class CategoryRepository extends AbstractRepository implements ICategoryRepository
{
    public function __construct(Category $category)
    {
        parent::__construct($category);
    }

    public function paginate(Request $request)
    {
        return $this->query()->with(['user'])->paginate($request->limit);
    }

    public function findByAttributes($attributes, Request $request)
    {
        return $this->query()->with(['user'])->search($attributes, $request->search);
    }

    public function get()
    {
        return $this->query()->active(EnumsCategory::ACTIVE)->get();
    }
}
