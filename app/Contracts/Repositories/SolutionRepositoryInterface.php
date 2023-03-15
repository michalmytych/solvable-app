<?php

namespace App\Contracts\Repositories;

use App\DTOs\SolutionDTO;
use Spatie\LaravelData\Contracts\DataCollectable;

interface SolutionRepositoryInterface
{
    /**
     * Find solution by id.
     */
    public function find(string $id): ?SolutionDTO;

    /**
     * Get all solutions for provided problem instance.
     */
    public function allByUser(string $userId): DataCollectable;

    /**
     * Update provided Solution database record with data.
     */
    public function update(string $id, array $data): SolutionDTO;
}
