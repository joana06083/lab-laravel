<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        InvalidOrderException::class,
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
        $this->renderable(function(Exception $e, $request) {
            return $this->handleException($request, $e);
        });
    }

    /**
     * Handle response from exception.
     *
     * @param Request $request
     * @param \Exception $exception
     * @return JsonResponse
     */
    private function handleException($request, Exception $exception)
    {
        // dd($exception);
        if ($request->expectsJson()) {
            if ($exception instanceof NotFoundHttpException) {
                return response()->json(
                    [
                        'error' => 'Http not found.'
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }
        }
        // switch (true) {
        //     case $exception instanceof NotFoundHttpException:
        //         return response()->json([
        //             'message' => 'Http not found.'
        //         ], 404);
        //     case $exception instanceof MethodNotAllowedHttpException:
        //         return response()->json([
        //             'message' => 'Method not allowed.'
        //         ], 405);
        //     case $exception instanceof UnauthorizedHttpException:
        //         return response()->json([
        //             'message' => 'Unauthorized.'
        //         ], 401);
        //     case $exception instanceof ModelNotFoundException:
        //         return response()->json([
        //             'message' => 'ModelNotFound.'
        //         ], 6001);    
        // }

        return parent::render($request, $exception);
    }
}
