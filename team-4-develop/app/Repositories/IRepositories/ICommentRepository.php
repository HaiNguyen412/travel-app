<?php

namespace App\Repositories\IRepositories;

use Illuminate\Http\Request;

interface ICommentRepository
{
    public function paginate(Request $request);
}
