<?php

namespace App\Services\IServices;

use Illuminate\Http\Request;
use App\Models\User;

interface IUserService
{
    public function paginate(Request $request);
    public function updateAvatar(Request $request);
    public function get(Request $request);
}
