<?php

namespace App\Contracts\Repositories;

use App\DTOs\CourseDTO;
use Spatie\LaravelData\Contracts\DataCollectable;

interface CourseRepositoryInterface
{
    /**
     * Get all courses related to user by user id.
     */
    public function allByUserId(string $id): DataCollectable;

    /**
     * Store new course in database.
     */
    public function store(array $data): CourseDTO;

    /**
     * Update course at database.
     */
    public function update(string $id, array $data): CourseDTO;

    /**
     * Delete course at database.
     */
    public function delete(string $id): bool;
}