<?php

namespace App\Repositories;

use App\Models\Problem;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Contracts\Problem\ProblemRepositoryInterface;

class ProblemRepository implements ProblemRepositoryInterface
{
    /**
     * Get all problems related to user by user id.
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
     */
    public function store(array $problemData): Problem
    {
        return Problem::create($problemData);
    }

    /**
     * Store new problem in database.
     */
    public function update(Problem $problem, array $data): Problem
    {
        return tap($problem)->update($data);
    }

    /**
     * Delete problem by id.
     */
    public function delete(Problem $problem): bool
    {
        return $problem->delete();
    }

    /**
     * Find problem by id.
     */
    public function findById(string $id): ?Problem
    {
        return Problem::find($id);
    }
}
