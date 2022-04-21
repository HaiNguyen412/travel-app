<?php

namespace App\Services\IServices;

use Illuminate\Http\Request;

interface ICategoryService
{
    public function paginate(Request $requet);
    public function create(Request $request);
    public function get();
}
