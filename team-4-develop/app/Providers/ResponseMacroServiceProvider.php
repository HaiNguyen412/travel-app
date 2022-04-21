<?php

namespace App\Providers;

use App\Http\Resources\JwtResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('indexSuccess', function ($data = null) {
            if ($data instanceof AnonymousResourceCollection) {
                return $data->additional([
                    'success' => true,
                ]);
            }
            if ($data instanceof JsonResource) {
                return $data;
            }

            return response()->json([
                'data' => $data,
                'success' => true,
            ]);
        });

        Response::macro('showSuccess', function ($data) {
            if ($data instanceof AnonymousResourceCollection) {
                return $data->additional([
                    'success' => true,
                ]);
            }

            if ($data instanceof JsonResource) {
                return $data;
            }

            return response()->json([
                'data' => $data,
                'success' => true,
            ]);
        });

        Response::macro('storeSuccess', function ($data = null) {
            if ($data instanceof JsonResource) {
                return $data->response()->setStatusCode(201);
            }

            return response()->json([
                'data' => $data,
                'success' => true,
            ], 201);
        });

        Response::macro('updateSuccess', function ($message = null, $code = 204) {
            if ($message) {
                return response()->json([
                    'message' => $message,
                    'success' => true,
                ], 200);
            }

            return response()->json()->setStatusCode(204);
        });

        Response::macro('deleteSuccess', function ($message = null) {
            if ($message) {
                return response()->json([
                    'message' => $message,
                    'success' => true,
                ], 200);
            }
            return response()->json()->setStatusCode(204);
        });

        Response::macro('clientError', function ($message = null, $code = 400) {
            return response()->json([
                'message' => $message ?? __('messages.errors.crud.client_error'),
                'success' => false
            ], $code);
        });

        Response::macro('serverError', function ($message = null, $code = 500) {
            return response()->json([
                'message' => $message ?? __('messages.errors.crud.common'),
                'success' => false
            ], $code);
        });

        Response::macro('showMessage', function ($message = null, $code = 200) {
            return response()->json([
                'message' => $message,
                'success' => true
            ], $code);
        });

        Response::macro('showMessageError', function ($message = null, $errors = null, $code = 422) {
            return response()->json([
                'message' => $message ?? __('message_error_page.422'),
                'errors' => $errors,
                'success' => false
            ], $code);
        });

        Response::macro('jwtAuth', function ($token = null, $expiredTimeExtend = 0) {
            return Response::showSuccess(
                JwtResource::make([
                    'access_token' => $token,
                    'expires_at' => Carbon::now()->addSeconds($expiredTimeExtend * 60),
                ])
            );
        });
    }
}
