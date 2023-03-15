<?php

namespace App\Repositories;

use App\Models\Problem;
use App\DTOs\ProblemDTO;
use Spatie\LaravelData\Contracts\DataCollectable;
use App\Contracts\Repositories\ProblemRepositoryInterface;

class ProblemRepository implements ProblemRepositoryInterface
{
    /**
     * Get all problems related to user by user id.
     */
    public function allByUser(string $userId): DataCollectable
    {
        $problemsPaginator = Problem::query()
            ->where('user_id', $userId)
            ->withQueryParams()
            ->paginate(10);

        return ProblemDTO::collection($problemsPaginator);
    }

    /**
     * Create and return new problem.
     */
    public function store(array $problemData): ProblemDTO
    {
        $problem = Problem::create($problemData);

        return ProblemDTO::from($problem);
    }

    /**
     * Store new problem in database.
     */
    public function update(Problem $problem, array $data): ProblemDTO
    {
        $problem = tap($problem)->update($data);

        return ProblemDTO::from($problem);
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
    public function findById(string $id): ?ProblemDTO
    {
        $problem = Problem::find($id);

        return ProblemDTO::from($problem);
    }
}
