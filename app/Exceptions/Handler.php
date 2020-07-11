<?php

namespace App\Exceptions;

use App\Exceptions\ThrottleException;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Throwable $e)
    {
        // if(app()->environment() === 'testing') throw $exception;
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $e)
    {
        if($e instanceof ValidationException){
            if($request->expectsJson()) {
                return response("Validation error", 422);
            }
        }
        if($e instanceof ThrottleException){
            return response("You are posting too frequently", 429);
        }

        return parent::render($request, $e);
    }
}
