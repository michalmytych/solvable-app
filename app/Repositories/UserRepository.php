<?php

namespace App\Repositories;

use App\Models\User;
use App\Contracts\Auth\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function store(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
    }

    public function findByEmail(string $email): ?User
    {
        return User::firstWhere('email', $email);
    }
}
