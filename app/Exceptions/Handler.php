<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (BroadcastException $e) {
            Log::channel('pusher')->error($e);
            return Response::serverError(__('messages.pusher.common_error'));
        });
        $this->renderable(function (ModelNotFoundException $e) {
            return Response::clientError(__('messages.errors.crud.not_exist'));
        });
        $this->renderable(function (NotFoundHttpException $e) {
            if ($e->getPrevious() instanceof ModelNotFoundException) {
                return Response::clientError(__('messages.errors.crud.not_exist'));
            }
            return Response::clientError(__('message_error_page.404.title'), 404);
        });
        $this->renderable(function (AuthenticationException $e) {
            return Response::clientError(__('alias_template.login.not_login'), 401);
        });
        $this->renderable(function (ValidationException $e) {
            return Response::showMessageError(__('message_error_page.422'), $e->errors());
        });
        $this->renderable(function (NotAuthorizedOnTournament $e) {
            return Response::clientError(__('messages.errors.crud.not_authorized'), 403);
        });
//        $this->renderable(function (HttpException $e, $request) {
//            return Response::clientError(__('message_error_page.'));
//        });
//        $this->reportable(function (Throwable $e) {
//        });
    }
}
