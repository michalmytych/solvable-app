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

    /**
     * Store new problem in database.
     *
     * @param array $data
     * @return Problem
     */
    public function store(array $data): Problem
    {
        return Problem::create($data);
    }
}
