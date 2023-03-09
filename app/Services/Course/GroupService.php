<?php

namespace App\Services\Course;

use App\Repositories\GroupRepository;
use Illuminate\Database\Eloquent\Collection;

class GroupService
{
    public function __construct(private GroupRepository $groupRepository) { }

    public function allByUser(string $userId): Collection
    {
        // @todo $userId
        return $this->groupRepository->allByUser();
    }
}
