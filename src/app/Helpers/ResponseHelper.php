<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ResponseHelper
{
    /**
     * @var int
     */
    private static int $exceptionStatusCode = 422;

    /**
     * @param array $message
     * @return JsonResponse
     */
    public static function created(array $message): JsonResponse
    {
        return response()->json($message, Response::HTTP_CREATED);
    }

    /**
     * @param array $message
     * @return JsonResponse
     */
    public static function results(array $message): JsonResponse
    {
        return \response()->json($message, Response::HTTP_OK);
    }

    /**
     * @param array $message
     * @return JsonResponse
     */
    public static function notFound(array $message): JsonResponse
    {
        return \response()->json($message, Response::HTTP_NOT_FOUND);
    }

    /**
     * @return JsonResponse
     */
    public static function noContent(): JsonResponse
    {
        return \response()->json([], Response::HTTP_NO_CONTENT);
    }

    public static function forbidden(array $message): JsonResponse
    {
        return \response()->json($message, Response::HTTP_FORBIDDEN);
    }

    /**
     * @param array $message
     * @return JsonResponse
     */
    public static function unprocessableEntity(array $message): JsonResponse
    {
        return \response()->json($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public static function exception($e): JsonResponse
    {
        return response()->json(['error' => self::getBodyException($e)], self::$exceptionStatusCode);
    }

    private static function getBodyException($exception)
    {
        if (is_string($exception))
            return $exception;

        if ($exception instanceof ValidationException)
            return ['validation' => $exception->errors()];

        if ($exception instanceof \Throwable) {
            if (in_array($exception->getCode(), [401, 403]))
                self::$exceptionStatusCode = $exception->getCode();
            else
                self::$exceptionStatusCode = Response::HTTP_UNPROCESSABLE_ENTITY;

            return $exception->getMessage();
        }
    }

}
