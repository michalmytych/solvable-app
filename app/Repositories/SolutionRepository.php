<?php

namespace App\Repositories;

use App\Models\Solution;
use App\DTOs\SolutionDTO;
use Spatie\LaravelData\Contracts\DataCollectable;
use App\Contracts\Repositories\SolutionRepositoryInterface;

class SolutionRepository implements SolutionRepositoryInterface
{
    public function find(string $id): ?SolutionDTO
    {
        $solution = Solution::findOrFail($id)
            ->query()
            ->withQueryParams()
            ->with('executions', fn($execution) => $execution->with('test'))
            ->first();

        return SolutionDTO::from($solution);
    }

    public function allByUser(string $userId): DataCollectable
    {
        $solutionsPaginator = Solution::query()
            ->where('user_id', $userId)
            ->withQueryParams()
            ->withQueryFilters()
            ->select([
                'id',
                'problem_id',
                'code_language_id',
                'status',
                'created_at',
                'updated_at'
            ])
            ->paginate(10);

        return SolutionDTO::collection($solutionsPaginator);
    }

    public function update(string $id, array $data): SolutionDTO
    {
        $solution = Solution::findOrFail($id);

        return SolutionDTO::from(
            tap($solution)->update($data)
        );
    }
}
