<?php

namespace App\Services\IServices;

use Illuminate\Http\Request;
use App\Models\Request as ModelRequest;

interface IRequestService
{
    public function paginateWhere(Request $request);
    public function paginate(Request $requet);
    public function createComment(ModelRequest $modelRequest, Request $requet);
    public function autoComment(ModelRequest $modelRequest, $content);
    public function approveRequest(ModelRequest $modelRequest);
    public function rejectRequest(ModelRequest $modelRequest);
}
