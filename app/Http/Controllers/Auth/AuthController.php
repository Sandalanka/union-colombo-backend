<?php

namespace App\Http\Controllers\Auth;

use App\Class\Common\ApiCatchErrors;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected AuthService $authService;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     *
     * Summery: User register
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            Log::info('User register request received', ['request_data' => $request->all()]);

            DB::beginTransaction();

            $register = $this->authService->register($request);

            DB::commit();

            return $this->successResponse(
                data: $register,
                message: 'User registered successfully.',
                statusCode: 201
            );

        } catch (Exception $exception) {
            ApiCatchErrors::rollback($exception, 'An error occurred while register a auth-(controller): ');

            return $this->errorResponse(
                exception: $exception,
                message: 'Something went wrong'
            );
        }
    }

    /**
     *
     * Summery: User login
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            Log::info('User login request received', ['request_data' => $request->all()]);

            $login = $this->authService->login($request);

            if (!$login['status']) {

                return $this->errorResponse(
                    message: 'Email or password is incorrect.',
                    statusCode: 401
                );
            }

            return $this->successResponse(
                data: $login,
                message: 'User login successfully.'
            );

        } catch (Exception $exception) {
            ApiCatchErrors::throw($exception, 'An error occurred while login a auth-(controller): ');

            return $this->errorResponse(
                exception: $exception,
                message: 'Something went wrong'
            );
        }
    }

    /**
     *
     * Summery: User logout
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authService->logout($request);

            return $this->successResponse(
                message: 'User logout successfully.'
            );

        } catch (Exception $exception) {
            ApiCatchErrors::throw($exception, 'An error occurred while logout a auth-(controller): ');

            return $this->errorResponse(
                exception: $exception,
                message: 'Something went wrong'
            );
        }
    }
}
