<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \League\OAuth2\Server\Exception\OAuthServerException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->wantsJson()) {
            if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
                \Errors::unAuthorized();
            }
            if ($exception instanceof \Illuminate\Database\QueryException) {
                \Errors::dbQueryError();
            } elseif ($exception instanceof \predis\connection\connectionexception) {
                \Errors::redisNotRunning();
            } elseif ($exception instanceof \GuzzleHttp\Exception\ClientException) {
                \Errors::connectionError();
            } elseif ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                $errors = $exception-> getStatusCode() === 404 ? 'not found' : $exception-> getMessage();
                return \Response::json(['errors' => [$errors]], $exception-> getStatusCode());
            } elseif ($exception instanceof \Illuminate\Validation\ValidationException) {
                return \Response::json(['errors' => $exception-> errors()], 422);
            } elseif (! $exception instanceof \Symfony\Component\ErrorHandler\Error\FatalError) {
                return parent::render($request, $exception);
            }
        }
        
        return parent::render($request, $exception);
    }
}
