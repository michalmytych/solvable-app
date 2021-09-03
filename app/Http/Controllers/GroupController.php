<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\Group\UpdateRequest;
use App\Models\Group;
use App\Repositories\GroupRepository;

class GroupController extends Controller
{
    private GroupRepository $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
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
