<?php

namespace App\Services\Auth\Api;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Exceptions\Auth\BadCredentialsException;

class UserService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    /**
     * Register new user if provided data is valid.
     */
    public function register(array $data): array
    {
        $user = $this->userRepository->store($data);

        $token = $user->createToken('api_token')->plainTextToken;

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    /**
     * Create token for user if user of provided credentials exists.
     * @throws BadCredentialsException
     */
    public function login(array $data): array
    {
        $user = $this->userRepository->findByEmail($data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new BadCredentialsException;
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    /**
     * Logout currently logged user.
     */
    public function logout(Authenticatable $user): void
    {
        $user->tokens()->delete();
    }
}