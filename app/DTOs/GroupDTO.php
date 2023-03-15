<?php

namespace App\DTOs;

class GroupDTO extends DTO
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $name,
        public readonly string $code,
        public readonly string $description,
        public readonly string $is_default,
        public readonly string $user_id,
    ) {}
}