<?php

namespace App\DTOs;

class CourseDTO extends DTO
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $name,
        public readonly string $slug,
        public readonly string $description,
        public readonly string $user_id,
    )
    {
    }
}