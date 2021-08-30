<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Contracts\Auth\UserControllerInterface;

class UserController extends Controller implements UserControllerInterface
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Register new user if provided data is valid.
     *
     * @param RegisterRequest $request
     * @return Response
     */
    public function register(RegisterRequest $request): Response
    {
        $data = $request->validated();

        $user = $this->userRepository->findByEmail($data['email']);

        $token = $user->createToken('api_token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    /**
     * Create token for user if user of provided credentials exists.
     *
     * @param LoginRequest $request
     * @return Response
     */
    public function login(LoginRequest $request): Response
    {
        $data = $request->validated();

        $user = $this->userRepository->findByEmail($data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response([
                'message' => 'auth.errors.bad-credentials'
            ], 401);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * Logout currently logged user.
     *
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request): Response
    {
        auth()->user()->tokens()->delete();

        return response([
            'message' => 'auth.messages.logged-out'
        ]);
    }
}
