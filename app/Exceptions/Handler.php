<?php

namespace App\Exceptions;

use Throwable;
use App\Exceptions\PermissionDeniedException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof UnauthorizedException) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'You are not authorized to perform this action.',
                ], 403);
            }

            $message = 'You are not authorized to perform this action.';
            return response()->view('errors.403', ['message' => $message], 403);
        }
        
        return parent::render($request, $exception);
    }

}
