<?php

namespace App\DTOs;

class GroupDTO extends DTO
{
    public function __construct(
        public ?string $id,
        public string $name,
        public string $code,
        public string $description,
        public string $is_default,
        public string $user_id,
    ) {}
}