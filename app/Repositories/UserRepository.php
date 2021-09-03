<?php

namespace App\Repositories;

use App\Models\User;
use App\Contracts\Auth\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Store new user in database.
     *
     * @param array $data
     * @return User
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
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return User::firstWhere('email', $email);
    }
}
