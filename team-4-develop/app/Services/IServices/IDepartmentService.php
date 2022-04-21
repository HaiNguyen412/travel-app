<?php

namespace App\Services\IServices;

use Illuminate\Http\Request;

interface IDepartmentService
{
    public function paginate(Request $request);
    public function get();
}
