<?php

namespace App\Services\IServices;

use Illuminate\Http\Request;

interface ICategoryService
{
    public function index(Request $request);
    public function store(Request $request);
    public function delete($id);
    public function update(Request $request, $id);
}