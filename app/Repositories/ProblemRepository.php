<?php

namespace App\Repositories;

use App\Models\Problem;
use Illuminate\Pagination\LengthAwarePaginator;

class ProblemRepository
{
    /**
     * Get all problems related to user by user id.
     *
     * @param string $id
     * @return LengthAwarePaginator
     */
    public function all(string $id): LengthAwarePaginator
    {
        // return Problem::where('user_id', $id)->paginate(10); // OG @todo
        return Problem::query()
            ->withQueryParams()
            ->paginate(10);
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

    /**
     * Store new problem in database.
     *
     * @param Problem $problem
     * @param array $data
     * @return Problem
     */
    public function update(Problem $problem, array $data): Problem
    {
        return tap($problem)->update($data);
    }

    /**
     * Delete problem by id.
     *
     * @param Problem $problem
     * @return bool
     */
    public function delete(Problem $problem): bool
    {
        return $problem->delete();
    }
}
