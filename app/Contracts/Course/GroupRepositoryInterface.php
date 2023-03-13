<?php

namespace App\Contracts\Course;

use App\Models\Group;
use App\DTOs\GroupDTO;
use Spatie\LaravelData\Contracts\DataCollectable;

interface GroupRepositoryInterface
{
    public function allByUser(string $userId): DataCollectable;

    public function update(Group $group, array $data): GroupDTO;

    public function syncProblems(Group $group, array $problemsIds): array;

    public function findByCourseId(string $courseId): DataCollectable;

    public function findById(string $groupId): ?GroupDTO;
}