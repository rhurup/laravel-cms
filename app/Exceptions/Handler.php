<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\App;

class Handler extends ExceptionHandler
{
    /**
     * A list of core exceptions we can override
     * @var array
     */
    protected $overrides = [
        // Laravel overrides
        'ErrorException' => \App\Exceptions\Laravel\ErrorException::class,
        'Illuminate\Auth\AuthenticationException' => \App\Exceptions\Laravel\AuthenticationException::class,
        'Illuminate\Auth\Access\AuthorizationException' => \App\Exceptions\Laravel\AccessDeniedException::class,
        'Illuminate\Database\Eloquent\ModelNotFoundException' => \App\Exceptions\Laravel\ModelNotFoundException::class,
        'Doctrine\DBAL\Driver\PDOException' => \App\Exceptions\Laravel\PDOException::class,
        'BadMethodCallException' => \App\Exceptions\Laravel\BadMethodCallException::class,
    ];

    /**
     * A list of the exception types that are not reported
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     * @throws Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }


    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }


    /**
     * Prepare exception for rendering.
     *
     * @param  \Throwable  $e
     * @return \Throwable
     */
    public function prepareException(Throwable $e)
    {
        $class = get_class($e);
        $override = $this->overrides[$class] ?? null;

        if ($override) {
            return new $override($e->getMessage(), $e->getCode(), $e);
        }

        return parent::prepareException($e);
    }


    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
            ? response()->json($this->convertExceptionToArray($exception), 401)
            : redirect()->guest($exception->redirectTo() ?? route('login'));
    }


    /**
     * Convert the given exception to an array.
     *
     * @param  \Throwable  $e
     * @return array
     */
    protected function convertExceptionToArray(Throwable $e)
    {
        // We compile a full exceptions incl traces when in debug mode
        if (config('app.debug')) {
            return parent::convertExceptionToArray($e);
        }

        // Else, compile a common array
        $array = [
            'status' => ($this->isHttpException($e) ? $this->getExceptionStatusCode($e) : $e->getCode()),
            'message' => ($this->isHttpException($e) ? $this->getExceptionStatusMessage($e) : $e->getMessage()),
        ];

        // Fallback if we didnt get anything
        $array['status'] = $array['status'] ?: 500;
        $array['message'] = $array['message'] ?: 'Server Error';

        // Also add debug if we're not on live
        if (!App::environment('production')) {
            $array['debug'] = [
                'env' => config('app.env'),
                'message' => $e->getMessage(),
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
        }

        return $array;
    }


    /**
     * @param $exception
     * @return mixed
     */
    private function getExceptionStatusCode($exception)
    {
        if (method_exists($exception, 'getStatusCode')) {
            return $exception->getStatusCode();
        }

        return $exception->getCode();
    }


    /**
     * @param $exception
     * @return mixed
     */
    private function getExceptionStatusMessage($exception)
    {
        if (method_exists($exception, 'getStatusMessage')) {
            return $exception->getStatusMessage();
        }

        return $exception->getMessage();
    }
}
