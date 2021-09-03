<?php

namespace App\Repositories;

use App\Models\Problem;

class ProblemRepository
{
    /**
     * Get all problems related to user by user id.
     *
     * @param string $id
     * @return mixed
     */
    public function allByUserId(string $id)
    {
        return Problem::where('user_id', $id);
    }
}
