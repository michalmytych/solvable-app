<?php

namespace App\DTOs;

class SolutionDTO extends DTO
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $code,
        public readonly int $score,
        public readonly string $user_id,
        public readonly string $problem_id,
        public readonly int $execution_time,
        public readonly string $code_language_id,
        public readonly int $memory_used,
        public readonly int $characters,
        public readonly int $status,
        public readonly ?ProblemDTO $problem = null
    ) {
    }
}