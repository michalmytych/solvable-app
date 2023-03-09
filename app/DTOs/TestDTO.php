<?php

namespace App\DTOs;

class TestDTO extends DTO
{
    public readonly string $input;

    public readonly int $memory_limit;

    public readonly int $time_limit;

    public readonly array $valid_outputs;

    public function __construct(
        string     $input,
        int|string $memory_limit,
        int|string $time_limit,
        array      $valid_outputs
    ) {
        $this->input         = $input;
        $this->memory_limit  = (int) $memory_limit;
        $this->time_limit    = (int) $time_limit;
        $this->valid_outputs = $valid_outputs;
    }
}