<?php

namespace App\Repositories\IRepositories;

use Illuminate\Http\Request;

interface ICategoryRepository
{
    public function paginate(Request $request);
    public function findByAttributes($attributes, Request $request);
    public function get();
}
