<?php

namespace App\Repositories;

use App\Models\User;
use App\DTOs\UserDTO;
use App\Contracts\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function store(array $data): UserDTO
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        return UserDTO::from($user);
    }

    public function findByEmail(string $email): ?UserDTO
    {
        $user = User::firstWhere('email', $email);

        return $user ? UserDTO::from($user) : $user;
    }
}
