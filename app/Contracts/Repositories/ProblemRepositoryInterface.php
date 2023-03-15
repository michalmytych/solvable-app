<?php

namespace App\Contracts\Repositories;

use App\Models\Problem;
use App\DTOs\ProblemDTO;
use Spatie\LaravelData\Contracts\DataCollectable;

interface ProblemRepositoryInterface
{
    /**
     * Get all problems related to user by user id.
     */
    public function allByUser(string $userId): DataCollectable;

    /**
     * Create and return new problem.
     */
    public function store(array $problemData): ProblemDTO;

    /**
     * Store new problem in database.
     */
    public function update(Problem $problem, array $data): ProblemDTO;

    /**
     * Delete problem by id.
     */
    public function delete(Problem $problem): bool;

    /**
     * Find problem by id.
     */
    public function findById(string $id): ?ProblemDTO;
}