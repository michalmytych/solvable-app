<?php

namespace App\Http\Controllers\Api\Course;

use App\Models\Group;
use App\Http\Controllers\Controller;
use App\Repositories\GroupRepository;
use App\Http\Requests\Api\Group\UpdateRequest;

class GroupController extends Controller
{
    public function __construct(private GroupRepository $groupRepository)
    {
    }

    /**
     * Update group and sync problems.
     *
     * @param Group $group
     * @param UpdateRequest $updateRequest
     */
    public function update(Group $group, UpdateRequest $updateRequest)
    {
        $data = $updateRequest->validated();

        $problemsIds = $data['problems_ids'];
        unset($data['problems_ids']);

        $this->groupRepository->update($group, $data);

        if (!empty($problemsIds)) {
            $this->groupRepository->syncProblems($group, $problemsIds);
        }
    }
}
