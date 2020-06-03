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
            if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                \ErrorHandler::unAuthorized();
            }
            if ($e instanceof \Illuminate\Database\QueryException) {
                \ErrorHandler::dbQueryError();
            } elseif ($e instanceof \predis\connection\connectionexception) {
                \ErrorHandler::redisNotRunning();
            } elseif ($e instanceof \GuzzleHttp\Exception\ClientException) {
                \ErrorHandler::connectionError();
            } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                $errors = $e->getStatusCode() === 404 ? 'not found' : $e->getMessage();
                return \Response::json(['errors' => [$errors]], $e->getStatusCode());
            } elseif ($e instanceof \Illuminate\Validation\ValidationException) {
                return \Response::json(['errors' => $e->errors()], 422);
            } elseif (! $e instanceof \Symfony\Component\ErrorHandler\Error\FatalError) {
                return parent::render($request, $e);
            }
        }
        
        return parent::render($request, $e);
    }
}
