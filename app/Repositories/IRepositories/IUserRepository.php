<?php

namespace App\Repositories\IRepositories;

use Illuminate\Http\Request;

interface IUserRepository
{
    public function paginate(Request $request);
    public function get(Request $request);
}
