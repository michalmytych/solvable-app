<?php /** @noinspection PhpFieldAssignmentTypeMismatchInspection */

namespace App\Services;

use App\Models\Problem;
use App\Models\Solution;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\SolutionRepository;

class SolutionService
{
    public function __construct(private SolutionRepository $solutionRepository) {}

    /**
     * Update solution database record using concrete repository.
     *
     * @param Solution $solution
     * @param array $data
     * @return Solution
     */
    public function updateSolution(Solution $solution, array $data): Solution
    {
        return $this->solutionRepository->update($solution, $data);
    }

    /**
     * Persist solution record.
     *
     * @param Problem $problem
     * @param array $solutionData
     * @return Model|Solution
     */
    public function createSolutionRecord(Problem $problem, array $solutionData): Model|Solution
    {
        return $problem
            ->solutions()
            ->create([
                'user_id' => Auth::id(),
                'code_language_id' => $solutionData['code_language_id']
            ]);
    }
}
