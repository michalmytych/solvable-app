<?php

namespace App\Contracts\Repositories;

use App\DTOs\GroupDTO;
use Spatie\LaravelData\Contracts\DataCollectable;

interface GroupRepositoryInterface
{
    public function allByUser(string $userId): DataCollectable;

    public function update(string $id, array $data): GroupDTO;

    public function syncProblems(string $groupId, array $problemsIds): array;

    public function findByCourseId(string $courseId): DataCollectable;

    public function findById(string $groupId): ?GroupDTO;
}