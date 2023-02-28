<?php

namespace App\Contracts\Repositories\Problem;

use App\Models\Problem;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProblemRepositoryInterface
{
    /**
     * Get all problems related to user by user id.
     */
    public function all(string $id): LengthAwarePaginator;

    /**
     * Create and return new problem.
     */
    public function store(array $problemData): Problem;

    /**
     * Store new problem in database.
     */
    public function update(Problem $problem, array $data): Problem;

    /**
     * Delete problem by id.
     */
    public function delete(Problem $problem): bool;

    /**
     * Find problem by id.
     */
    public function findById(string $id): ?Problem;
}