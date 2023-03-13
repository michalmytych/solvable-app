<?php

namespace App\Repositories;

use App\Models\Group;
use App\Models\Course;
use App\DTOs\GroupDTO;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\Contracts\DataCollectable;
use App\Contracts\Course\GroupRepositoryInterface;

class GroupRepository implements GroupRepositoryInterface
{
    /**
     * Get all groups available to user.
     */
    public function allByUser(string $userId): DataCollectable
    {
        $groupsData = Group::where('user_id', $userId)->latest()->get()->toArray();

        return GroupDTO::collection($groupsData);
    }

    /**
     * Update provided group with data and return it.
     */
    public function update(Group $group, array $data): GroupDTO
    {
        $data = tap($group)->update($data);

        return GroupDTO::from($data);
    }

    /**
     * Sync problems at group with ones from provided ids array.
     */
    public function syncProblems(Group $group, array $problemsIds): array
    {
        return DB::transaction(fn() => $group->problems()->sync($problemsIds));
    }

    /**
     * Get groups of course by course id.
     */
    public function findByCourseId(string $courseId): DataCollectable
    {
        $course = Course::find($courseId);

        return GroupDTO::collection(optional($course)->groups);
    }

    /**
     * Find group by id.
     */
    public function findById(string $groupId): ?GroupDTO
    {
        $data = Group::find($groupId);

        return GroupDTO::from($data);
    }
}
