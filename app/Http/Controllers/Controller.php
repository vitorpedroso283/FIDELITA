<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    /**
     * Success Response.
     *
     * @param mixed $data
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function successResponse($data, $statusCode = 200, $response = 'success'): JsonResponse
    {
        return response()->json(['response' => $response, 'data' => $data], $statusCode)->header('Content-Type', 'application/json');
    }

    /**
     * Error Response.
     *
     * @param string|array $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function errorResponse($message, $statusCode, $response = 'error'): JsonResponse
    {
        if (is_array($message)) {
            return response()->json(['response' => $response, 'errors' => $message], $statusCode)->header('Content-Type', 'application/json');
        }

        return response()->json(['status' => 'error', 'message' => $message], $statusCode)->header('Content-Type', 'application/json');
    }
}
