<?php

namespace App\Repositories\Auth;

use App\Class\Common\ApiCatchErrors;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
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
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user->save();

            return [
                'user' => $user
            ];

        } catch (Exception $exception) {
            ApiCatchErrors::throw($exception,
                'An error occurred while register a auth-(repository): '
            );

            throw $exception;
        }
    }

    /**
     *
     * Summery: User login
     *
     * @param Request $request
     * @return array|false[]
     * @throws Exception
     */
    public function login(Request $request): array
    {
        try {
            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                $user->tokens()->delete();
                $token = $user->createToken('Personal Access Token')->plainTextToken;

                return [
                    'status' => true,
                    'user' => $user,
                    'token' => $token
                ];
            }

            return [
                'status' => false
            ];

        } catch (Exception $exception) {
            ApiCatchErrors::throw($exception,
                'An error occurred while login a auth-(repository): '
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
            $request->user()->currentAccessToken()->delete();

        } catch (Exception $exception) {
            ApiCatchErrors::throw($exception,
                'An error occurred while logout a auth-(repository): '
            );

            throw $exception;
        }
    }
}
