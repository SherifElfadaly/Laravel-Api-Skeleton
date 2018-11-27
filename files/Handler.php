<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $exception
	 * @return void
	 */
	public function report(Exception $exception)
	{
		parent::report($exception);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $exception
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $exception)
	{
		if ($request->wantsJson())
		{
			if ($exception instanceof \Illuminate\Auth\AuthenticationException) 
			{
				\ErrorHandler::unAuthorized();
			}
			if ($exception instanceof \Illuminate\Database\QueryException) 
			{
				\ErrorHandler::dbQueryError();
			} else if ($exception instanceof \predis\connection\connectionexception) 
			{
				\ErrorHandler::redisNotRunning();
			} else if ($exception instanceof \GuzzleHttp\Exception\ClientException) 
			{
				\ErrorHandler::connectionError();
			} else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) 
			{
				return \Response::json($exception->getMessage(), $exception->getStatusCode());   
			} else if ($exception instanceof \Illuminate\Validation\ValidationException) 
			{
				return \Response::json($exception->errors(), 422);   
			} else if ( ! $exception instanceof \Symfony\Component\Debug\Exception\FatalErrorException)
			{
				return parent::render($request, $exception);
			}
		} else
		{
			return parent::render($request, $exception);
		}
	}
}
