<?php

namespace App\DTOs;

class CodeLanguageDTO extends DTO
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $name,
        public readonly string $identifier,
        public readonly int $version,
    )
    {
    }
}