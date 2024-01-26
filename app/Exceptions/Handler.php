<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        switch (true) {
            case $e instanceof ValidationException:
                return response()->json([
                    'status' => '422',
                    'message' => $e->getMessage(),
                    'data' => $e->errors(),
                ]);
            case $e instanceof AuthenticationException:
                return response()->json([
                    'status' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'data' => null,
                ]);
            default:
                return response()->json([
                    'status' => $e->getCode(),
                    'message' => $e->getMessage(),
                    'data' => get_class($e),
                ]);
        }
    }
}
