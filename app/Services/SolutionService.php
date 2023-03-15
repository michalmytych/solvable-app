<?php /** @noinspection PhpFieldAssignmentTypeMismatchInspection */

namespace App\Services;

use App\Models\User;
use App\Models\Problem;
use App\Models\Solution;
use App\DTOs\SolutionDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\Contracts\DataCollectable;
use App\Contracts\Repositories\SolutionRepositoryInterface;

class SolutionService
{
    public function __construct(private SolutionRepositoryInterface $solutionRepository) { }

    /**
     * Get all solutions by user.
     */
    public function all(User $user): DataCollectable
    {
        return $this->solutionRepository->allByUser($user->id);
    }

    /**
     * Find solution by id.
     */
    public function find(Solution $solution): SolutionDTO
    {
        return $this->solutionRepository->find($solution);
    }

    /**
     * Update solution database record using concrete repository.
     */
    public function updateSolution(Solution $solution, array $data): SolutionDTO
    {
        return $this->solutionRepository->update($solution, $data);
    }

    /**
     * Persist solution record.
     */
    public function createSolutionRecord(Problem $problem, array $solutionData): Model|Solution
    {
        return $problem     // @todo
            ->solutions()
            ->create([
                'user_id'          => Auth::id(),
                'code_language_id' => $solutionData['code_language_id'],
            ]);
    }
}
