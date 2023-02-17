<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\Auth\Api\UserService;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Contracts\Auth\UserControllerInterface;
use App\Exceptions\Auth\BadCredentialsException;

class UserController extends Controller implements UserControllerInterface
{
    public function __construct(private UserService $userService)
    {
    }

    /**
     * Register new user if provided data is valid.
     */
    public function register(RegisterRequest $request): Response
    {
        $result = $this->userService->register(
            $request->validated()
        );

        return response($result, 201);
    }

    /**
     * Create token for user if user of provided credentials exists.
     */
    public function login(LoginRequest $request): Response
    {

        try {
            $result = $this->userService->login($request->validated());

        } catch (BadCredentialsException) {
            return response([
                'message' => 'auth.errors.bad-credentials',
            ], 401);
        }

        return response($result);
    }

    /**
     * Logout currently logged user.
     */
    public function logout(Request $request): Response
    {
        $this->userService->logout(auth()->user());

        return response([
            'message' => 'auth.messages.logged-out',
        ]);
    }

    /**
     * Get authorized user.
     */
    public function user(Request $request): Response
    {
        return response([
            'user'  => $request->user(),
            'token' => $request->bearerToken(),
        ]);
    }
}
