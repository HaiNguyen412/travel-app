<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Response;
use Str;

class LoginBySocialController extends Controller
{
    public function loginSocial($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function loginSocialGetUser($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        $token = $user->token;
        return Response::json(['token' => $token]);
    }
}
