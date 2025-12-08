<?php

namespace App\Swagger;

/**
 * @OA\Post(
 *     path="/api/v1/auth/register",
 *     summary="User Register",
 *     description="Auth user register",
 *     tags={"Authentication"},
 *
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","email","password","password_confirmation"},
 *             @OA\Property(property="name", type="string", example="Isuru"),
 *             @OA\Property(property="email", type="string", format="email", example="test001@iposg.com"),
 *             @OA\Property(
 *                 property="password",
 *                 type="string",
 *                 example="Test@123",
 *                 description="Min 8 chars, must include uppercase, lowercase, number, symbol"
 *             ),
 *              @OA\Property(
 *                  property="password_confirmation",
 *                  type="string",
 *                  example="Test@123",
 *                  description="Min 8 chars, must include uppercase, lowercase, number, symbol"
 *              )
 *         )
 *     ),
 * *
 *     @OA\Response(
 *         response=200,
 *         description="User registered successfully",
 *         @OA\JsonContent(
 *            @OA\Property(property="status", type="string", example="success"),
 *            @OA\Property(property="timestamp", type="string", example="2025-11-30 14:24:05"),
 *            @OA\Property(property="message", type="string", example="User registered successfully."),
 *            @OA\Property(
 *                property="data",
 *                type="object",
 *                @OA\Property(
 *                    property="user",
 *                    type="object",
 *                    @OA\Property(property="id", type="integer", example=9),
 *                    @OA\Property(property="name", type="string", example="Isuru Sandalanka"),
 *                    @OA\Property(property="email", type="string", example="test001@iposg.com"),
 *                )
 *            )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=422,
 *         description="Validation Error",
 *         @OA\JsonContent(
 *            @OA\Property(property="status", type="boolean", example=false),
 *            @OA\Property(property="message", type="string", example="Validation errors"),
 *            @OA\Property(
 *                property="errors",
 *                type="object",
 *                example={
 *                    "email": {"The email field is required."},
 *                    "password": {"The password field is required."}
 *                }
 *            ),
 *            @OA\Property(property="timestamp", type="string", example="2025-10-31 05:30:24")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=500,
 *         description="Internal Server Error",
 *         @OA\JsonContent(
 *            @OA\Property(property="status", type="string", example="Error"),
 *            @OA\Property(property="message", type="string", example="Something went wrong.")
 *         )
 *     )
 * )
 *
 * @OA\Post(
 *      path="/api/v1/auth/login",
 *      tags={"Authentication"},
 *      summary="User Login",
 *      description="Login using email and password.",
 *
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"email","password"},
 *              @OA\Property(property="email", type="string", format="email", example="test001@iposg.com"),
 *              @OA\Property(property="password", type="string", minLength=6, example="123456")
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="Success",
 *          @OA\JsonContent(
 *              @OA\Property(property="status", type="string", example="success"),
 *              @OA\Property(property="timestamp", type="string", example="2025-11-30 14:24:05"),
 *              @OA\Property(property="message", type="string", example="User login successfully."),
 *              @OA\Property(property="data", type="object",
 *                  @OA\Property(property="user", type="object",
 *                      @OA\Property(property="id", type="integer", example=9),
 *                      @OA\Property(property="name", type="string", example="Isuru Sandalanka"),
 *                      @OA\Property(property="email", type="string", example="test001@iposg.com")
 *                  ),
 *                  @OA\Property(property="token", type="string", example="9|AASD98ASD8A7SD8A7D")
 *              )
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=401,
 *          description="Incorrect email/password",
 *          @OA\JsonContent(
 *              @OA\Property(property="status", type="integer", example=401),
 *              @OA\Property(property="message", type="string", example="Email or password is incorrect."),
 *              @OA\Property(property="timestamp", type="string", example="2025-10-31 05:30:24")
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=422,
 *          description="Validation Error",
 *          @OA\JsonContent(
 *              @OA\Property(property="status", type="boolean", example=false),
 *              @OA\Property(property="message", type="string", example="Validation errors"),
 *              @OA\Property(property="errors", type="object",
 *                  @OA\Property(property="email", type="array",
 *                      @OA\Items(type="string", example="The email field is required.")
 *                  ),
 *                  @OA\Property(property="password", type="array",
 *                      @OA\Items(type="string", example="The password field is required.")
 *                  )
 *              ),
 *              @OA\Property(property="timestamp", type="string", example="2025-10-31 05:30:24")
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=500,
 *          description="Server Error",
 *          @OA\JsonContent(
 *              @OA\Property(property="status", type="string", example="Error"),
 *              @OA\Property(property="message", type="string", example="Something went wrong."),
 *              @OA\Property(property="timestamp", type="string", example="2025-10-31 05:30:24")
 *          )
 *      )
 *  )
 *
 * @OA\Get(
 *      path="/api/v1/auth/logout",
 *      tags={"Authentication"},
 *      summary="User Logout",
 *      description="Revoke the user's current access token and logout.",
 *      security={{"bearerAuth":{}}},
 *
 *      @OA\Response(
 *          response=200,
 *          description="Logout successful",
 *          @OA\JsonContent(
 *              @OA\Property(property="status", type="string", example="success"),
 *              @OA\Property(property="timestamp", type="string", example="2025-11-30 14:24:05"),
 *              @OA\Property(property="message", type="string", example="User logout successfully.")
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=500,
 *          description="Server Error",
 *          @OA\JsonContent(
 *              @OA\Property(property="status", type="string", example="Error"),
 *              @OA\Property(property="message", type="string", example="Something went wrong."),
 *              @OA\Property(property="timestamp", type="string", example="2025-10-31 05:30:24")
 *          )
 *      )
 *  )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 *
 *
 */
class AuthControllerDocs
{
    public function __construct()
    {
        //
    }
}
