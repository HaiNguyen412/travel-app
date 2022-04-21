<?php

namespace App\Services\IServices;

use Illuminate\Http\Request;

interface ICommentService
{
    public function paginate(Request $request);
}
