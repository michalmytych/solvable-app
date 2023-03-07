<?php

namespace App\Repositories;

use App\Models\Group;
use App\Models\Course;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class GroupRepository
{
    /**
     * Get all groups available to user.
     */
    public function allByUser(): EloquentCollection
    {
        // @todo dont use auth facade instead add userId function argument
        return Group::where('user_id', Auth::id())->latest()->get();
    }

    /**
     * Update provided group with data and return it.
     */
    public function update(Group $group, array $data): Group
    {
        return tap($group)->update($data);
    }

    /**
     * Sync problems at group with ones from provided ids array.
     */
    public function syncProblems(Group $group, array $problemsIds): void
    {
        DB::transaction(fn() => $group->problems()->sync($problemsIds));
    }

    /**
     * Get groups of course by course id.
     */
    public function findByCourseId(string $courseId): ?Collection
    {
        $course = Course::find($courseId);

        return optional($course)->groups;
    }

    /**
     * Find group by id.
     */
    public function findById(string $groupId)
    {
        return Group::find($groupId);
    }
}
