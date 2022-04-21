<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\JwtResource;
use App\Http\Resources\UserResource;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use Laravel\Socialite\Facades\Socialite;
use phpDocumentor\Reflection\Types\Resource_;
use Str;

class AuthController extends Controller
{
    private $userService;

    public function __construct()
    {
        $this->middleware(['jwt.auth'], ['except' => ['login', 'loginSocialHandle', 'loginWithGoogle']]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return Response::clientError(__('auth.password'));
            } else {
                $credentials['email_verified_at'] = null;
                if ($token = JWTAuth::attempt($credentials)) {
                    return Response::clientError(__('auth.verify'));
                } else {
                    unset($credentials['email_verified_at']);
                    $credentials['status'] = 1;
                    if (!$token = JWTAuth::attempt($credentials)) {
                        return Response::clientError(__('auth.status'));
                    }
                }
            }
        } catch (JWTException $e) {
            return Response::serverError(__('exception.server_error'));
        }
        return Response::jwtAuth($token, Config::get('jwt.ttl'));
    }

    public function me(Request $request)
    {
        return Response::showSuccess(
            JWTAuth::toUser($request->token)->load(['department', 'position', 'role'])
        );
    }
    public function logout()
    {
        return Response::showSuccess(JWTAuth::invalidate(JWTAuth::getToken()));
    }

    public function loginSocialHandle($provider, Request $request)
    {
        $token = $request->token;
        try {
            // dd($provider);
            $user = Socialite::driver($provider)->userFromToken($token);
            // dd($user);
        } catch (Exception $e) {
            return Response::clientError(__('auth.google_access'));
        }

        if ($provider === 'google') {
            $token = $this->loginWithGoogle($user);
        }
        if (!is_string($token)) {
            return $token;
        }

        return Response::jwtAuth($token, Config::get('jwt.ttl'));
    }

    public function loginWithGoogle($user)
    {
        $getUser = User::where([
            'google_token' => $user->id,
            'email' => $user->email,
        ])->first();
        if (!$getUser) {
            $getUserByEmail = User::where('email', $user->email)->first();
            if (!$getUserByEmail) {
                try {
                    $userEmailArray = explode('@', $user->email);
                    if (strtolower($userEmailArray[1]) == 'hblab.vn') {
                        $getUser = User::create([
                            'email' => $user->email,
                            'password' => Str::random(10),
                            'code_login' => $userEmailArray[0],
                            'name' => $user->name,
                            'status' => 1,
                            'avatar' => $user->avatar,
                            'google_token' => $user->id,
                            'role_id' => 2,
                            'email_verified_at' => now(),
                        ]);
                    } else {
                        return Response::clientError(__('auth.google_permission'));
                    }
                } catch (Exception $e) {
                    return Response::serverError(__('exception.server_error'));
                }
            } else {
                $getUser = $getUserByEmail->fill(['google_token' => $user->id]);
                $getUser->save();
            }
        }
        if (!$getUser->email_verified_at) {
            $getUser->fill(['email_verified_at' => now()]);
            $getUser->save();
        }
        if (!$getUser->status) {
            return Response::clientError(__('auth.status'));
        }
        $token = auth()->login($getUser);
        
        return $token;
    }
}
