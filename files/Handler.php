<?php

namespace App\Exceptions;

use App\Modules\Core\Facades\Errors;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
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
        $errors = $this->getErrorHandlers();

        if ($request->wantsJson()) {
            $exceptionClass = get_class($exception);
            return Arr::has($errors, $exceptionClass) ? $errors[$exceptionClass]($request, $exception) : parent::render($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Return handler for defined error types
     *
     * @return  array
     */
    protected function getErrorHandlers()
    {
        return [
            \Illuminate\Auth\AuthenticationException::class => function ($request, $exception) {
                Errors::unAuthorized();
            },
            \Illuminate\Database\QueryException::class => function ($request, $exception) {
                Errors::dbQueryError();
            },
            \predis\connection\connectionexception::class => function ($request, $exception) {
                Errors::redisNotRunning();
            },
            \RedisException::class => function ($request, $exception) {
                Errors::redisNotRunning();
            },
            \GuzzleHttp\Exception\ClientException::class => function ($request, $exception) {
                Errors::connectionError();
            },
            \Symfony\Component\HttpKernel\Exception\HttpException::class => function ($request, $exception) {
                return response()->json(['errors' => [$exception->getStatusCode() === 404 ? 'not found' : $exception->getMessage()]], $exception->getStatusCode());
            },
            \Illuminate\Validation\ValidationException::class => function ($request, $exception) {
                response()->json(['errors' => $exception->errors()], 422);
            }
        ];
    }
}
