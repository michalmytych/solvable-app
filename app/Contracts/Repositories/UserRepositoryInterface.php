<?php

namespace App\Contracts\Repositories;

use App\DTOs\UserDTO;

interface UserRepositoryInterface
{
    /**
     * Store new user in database.
     */
    public function store(array $data): UserDTO;

    /**
     * Find user by his e-mail address.
     */
    public function findByEmail(string $email): ?UserDTO;
}
