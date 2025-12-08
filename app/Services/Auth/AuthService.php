<?php

namespace App\Services\Auth;

use App\Class\Common\ApiCatchErrors;
use App\Repositories\Auth\AuthRepository;
use Exception;
use Illuminate\Http\Request;

class AuthService
{
    protected AuthRepository $authRepository;

    /**
     * @param AuthRepository $authRepository
     */
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     *
     * Summery: User register
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function register(Request $request): array
    {
        try {
            return $this->authRepository->register($request);

        } catch (Exception $exception) {
            ApiCatchErrors::throw($exception,
                'An error occurred while register a auth-(service): '
            );

            throw $exception;
        }
    }

    /**
     *
     * Summery: User login
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function login(Request $request): array
    {
        try {
            return $this->authRepository->login($request);

        } catch (Exception $exception) {
            ApiCatchErrors::throw($exception,
                'An error occurred while login a auth-(service): '
            );

            throw $exception;
        }
    }

    /**
     *
     * Summery: User logout
     *
     * @param Request $request
     * @return void
     * @throws Exception
     */
    public function logout(Request $request): void
    {
        try {
            $this->authRepository->logout($request);

        } catch (Exception $exception) {
            ApiCatchErrors::throw($exception,
                'An error occurred while logout a auth-(service): '
            );

            throw $exception;
        }
    }
}
