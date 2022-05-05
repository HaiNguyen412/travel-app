<?php

namespace App\Services\IServices;

use Illuminate\Http\Request;

interface IBlogService
{
    public function index(Request $request);
    public function create(Request $request);
    public function update(int $id, Request $request);
    public function delete($id);
    public function like(Request $request);
    public function dislike(Request $request);
}
