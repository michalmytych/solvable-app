<?php

namespace App\Services\Course;

use App\Repositories\GroupRepository;
use Illuminate\Database\Eloquent\Collection;

class GroupService
{
    public function __construct(private GroupRepository $groupRepository) { }

    public function allByUser(): Collection
    {
        return $this->groupRepository->allByUser();
    }
}
