<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class EmailVerificationController extends Controller
{
    public function sendVerificationEmail()
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return [
                'message' => 'Already Verified'
            ];
        }
        Auth::user()->sendEmailVerificationNotification();

        return ['status' => 'verification-link-sent'];
    }

    // public function verify(EmailVerificationRequest $request)
    // {
    //     if ($request->user()->hasVerifiedEmail()) {
    //         return [
    //             'message' => 'Email already verified'
    //         ];
    //     }

    //     if ($request->user()->markEmailAsVerified()) {
    //         event(new Verified($request->user()));
    //     }

    //     return [
    //         'message'=>'Email has been verified'
    //     ];
    // }

    public function verify($id, Request $request)
    {
        $user = User::where('id', $id)->first();
        if (!$user->hasVerifiedEmail()) {
            if ($user->markEmailAsVerified()) {
                event(new Verified($request->user()));
            }
        }
        return Redirect::to(config('app.client_url').'/verify-account');
    }
}
