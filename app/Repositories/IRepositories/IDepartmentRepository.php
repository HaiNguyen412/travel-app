<?php

namespace App\Repositories\IRepositories;

use Illuminate\Http\Request;

interface IDepartmentRepository
{
    public function paginate(Request $request);
    public function get();
}
