<?php

namespace App\Repositories;

use App\Models\User;
use App\Contracts\Auth\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Store new user in database.
     */
    public function store(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
    }

    /**
     * Find user by his e-mail address.
     */
    public function findByEmail(string $email): ?User
    {
        return User::firstWhere('email', $email);
    }
}
