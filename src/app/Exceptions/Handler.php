<?php

namespace App\Exceptions;

use App\Helpers\ResponseHelper;
use App\Services\Logging\Facades\Logging;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * A list of exception types that with a general message error
     * @var array|string[]
     */
    private array $defaultRenderClasses = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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

    public function render($request, Throwable $e)
    {
        dd($e->getMessage());
        if (!env('APP_DEBUG')) {
            //TODO:: implementar traduções trans() / logging

            if ($e instanceof ValidationException)
                return ResponseHelper::unprocessableEntity([
                    'message' => $e->getMessage(),
                    'errors' => $e->errors()
                ]);

            if ($e instanceof NotFoundHttpException)
                return ResponseHelper::notFound(['error' => 'router.does-not-match']);

            if ($e instanceof ModelNotFoundException)
                return ResponseHelper::notFound(['error' => 'model.not-found']);

            if ($e instanceof MethodNotAllowedHttpException)
                return ResponseHelper::forbidden(['error' => 'router.does-not-allowed']);

            if ($e instanceof Throwable)
                return ResponseHelper::exception(['message' => $e->getMessage()]);
        }

        return parent::render($request, $e);
    }
}
