<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class BaseRequest extends FormRequest
{
    /**
     *
     * Summary: Determine if the user is authorized to make this request
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     *
     * Summary: Request failedValidation response
     *
     * @param Validator $validator
     * @return JsonResponse
     */
    public function failedValidation(Validator $validator): JsonResponse
    {
        Log::error('Validation failed', [
            'request_class' => static::class,
            'controller_action' => $this->route()->getActionName(),
            'request_data' => $this->all(),
            'validation_errors' => $validator->errors()->all(),
            'user_id' => auth()->id() ?? null,
            'timestamp' => now()->toDateTimeString()
        ]);

        $response = [
            'status' => 'failed',
            'message' => 'Validation errors',
            'errors' => $validator->errors(),
            'timestamp' => now()->toDateTimeString()
        ];

        throw new HttpResponseException(response()->json($response, 422, [
                'Access-Control-Allow-Origin' => '*',
                'Content-Type' => 'application/json'
            ]
        ));
    }
}
