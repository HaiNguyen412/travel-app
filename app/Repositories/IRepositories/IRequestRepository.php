<?php

namespace App\Repositories\IRepositories;

use App\Models\User;
use Illuminate\Http\Request;

interface IRequestRepository
{
    public function paginateWhere(Request $request);
    public function paginate(Request $request);
}
