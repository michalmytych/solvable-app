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
    public function findByUser(string $id)
    {
        return Problem::where('user_id', $id)->get();
    }

    /**
     * Create and return new problem.
     *
     * @param array $problemData
     * @return Problem
     */
    public function store(array $problemData): Problem
    {
        return Problem::create($problemData);
    }
}
