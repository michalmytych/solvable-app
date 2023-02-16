<?php /** @noinspection PhpFieldAssignmentTypeMismatchInspection */

namespace App\Services;

use App\Models\Problem;
use App\Models\Solution;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\SolutionRepository;

class SolutionService
{
    public function __construct(private SolutionRepository $solutionRepository) { }

    /**
     * Update solution database record using concrete repository.
     */
    public function updateSolution(Solution $solution, array $data): Solution
    {
        return $this->solutionRepository->update($solution, $data);
    }

    /**
     * Persist solution record.
     */
    public function createSolutionRecord(Problem $problem, array $solutionData): Model|Solution
    {
        return $problem
            ->solutions()
            ->create([
                'user_id'          => Auth::id(),
                'code_language_id' => $solutionData['code_language_id'],
            ]);
    }
}
