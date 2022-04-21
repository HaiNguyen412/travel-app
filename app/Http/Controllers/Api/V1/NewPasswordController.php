<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\Enums\User as EnumsUser;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class NewPasswordController extends Controller
{
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $email = $request->only('email');
            $activeUser = User::query()->where('email', $email)->where('status', EnumsUser::DISABLE)->count();
            if (!empty($activeUser)) {
                return response()->json([
                    'message' => 'email not exist'
                ]);
            }
            $status = Password::sendResetLink(
                $request->only('email')
            );
            if ($status == Password::RESET_LINK_SENT) {
                return [
                    'status' => true//__($status)
                ];
            }
            
            return ['status' => false];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function reset(ResetPasswordRequest $request)
    {
        try {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user) use ($request) {
                    $user->forceFill([
                        'password' => $request->password,
                        'remember_token' => Str::random(60),
                    ])->save();

                    $user->tokens()->delete();

                    event(new PasswordReset($user));
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                return response([
                    'status' => true
                ]);
            }
            
            return response([
                'status' => false
            ]);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
