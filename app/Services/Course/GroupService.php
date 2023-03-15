<?php

namespace App\Services\Course;

use Spatie\LaravelData\Contracts\DataCollectable;
use App\Contracts\Repositories\GroupRepositoryInterface;

class GroupService
{
    public function __construct(private GroupRepositoryInterface $groupRepository) { }

    public function allByUser(string $userId): DataCollectable
    {
        return $this->groupRepository->allByUser($userId);
    }
}
