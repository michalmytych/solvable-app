<?php

namespace App\DTOs;

class UserDTO extends DTO
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
    ) { }
}