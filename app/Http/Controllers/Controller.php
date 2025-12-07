<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use App\Constants\Messages;
use Illuminate\Http\Exceptions\HttpResponseException;
use Exception;
use Illuminate\Support\Collection;

abstract class Controller
{
    /**
     *
     * Summary: Return a success JSON response
     *
     * @param array|Collection|Arrayable|null $data
     * @param string|null $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function successResponse(array|Collection|Arrayable $data = null,
                                       string                     $message = null,
                                       int                        $statusCode = 200): JsonResponse
    {
        $response = [
            'status' => 'success',
            'timestamp' => now()->toDateTimeString()
        ];

        if ($message !== null) {
            $response['message'] = $message;
        }

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode, [
                'Access-Control-Allow-Origin' => '*',
                'Content-Type' => 'application/json'
            ]
        );
    }

    /**
     *
     * Summary: Return an error JSON response
     *
     * @param array|Collection|Arrayable $data
     * @param Exception|null $exception
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function errorResponse(array|Collection|Arrayable $data = [],
                                     Exception                  $exception = null,
                                     string                     $message = Messages::GENERAL_RESPONSE_ERROR_MESSAGE,
                                     int                        $statusCode = 500): JsonResponse
    {
        $response = [
            'status' => 'error',
            'message' => $message,
            'timestamp' => now()->toDateTimeString()
        ];

        if ($exception !== null) {
            $response['errors'] = $exception->getMessage();
        }

        if (!empty($data)) {
            $response['data'] = $data;
        }

        throw new HttpResponseException(response()->json($response, $statusCode, [
                'Access-Control-Allow-Origin' => '*',
                'Content-Type' => 'application/json'
            ]
        ));
    }
}
