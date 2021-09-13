<?php

namespace App\Repositories;

use App\Models\Group;
use Illuminate\Support\Facades\DB;

class GroupRepository
{
    /**
     * Update provided group with data and return it.
     *
     * @param Group $group
     * @param array $data
     * @return Group
     */
    public function update(Group $group, array $data): Group
    {
        return tap($group)->update($data);
    }

    /**
     * Sync problems at group with ones from provided ids array.
     *
     * @param Group $group
     * @param array $problemsIds
     * @return void
     */
    public function syncProblems(Group $group, array $problemsIds): void
    {
        DB::transaction(fn() => $group->problems()->sync($problemsIds));
    }
}
