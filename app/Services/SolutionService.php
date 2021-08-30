<?php /** @noinspection PhpFieldAssignmentTypeMismatchInspection */

namespace App\Services;

use App\Models\Problem;
use App\Models\Solution;
use App\Enums\SolutionStatusType;
use App\Repositories\SolutionRepository;
use App\Contracts\CodeExecutor\CodeExecutorServiceInterface;

class SolutionService
{
    private Solution $solution;

    private Problem $problem;

    private array $solutionData;

    private SolutionRepository $solutionRepository;

    private CodeExecutorServiceInterface $codeExecutorService;

    private SolutionValidationService $solutionValidationService;

    public function __construct(
        SolutionRepository $solutionRepository,
        SolutionValidationService $solutionValidationService,
        CodeExecutorServiceInterface $codeExecutorService
    )
    {
        $this->solutionRepository = $solutionRepository;
        $this->codeExecutorService = $codeExecutorService;
        $this->solutionValidationService = $solutionValidationService;
    }

    /**
     * Set problem for which solution is processed.
     *
     * @param Problem $problem
     * @return $this
     */
    public function setProblem(Problem $problem): SolutionService
    {
        $this->problem = $problem;

        return $this;
    }

    /**
     * Set data to create a Solution of.
     *
     * @param array $data
     * @return $this
     */
    public function setSolutionData(array $data): self
    {
        $this->solutionData = $data;

        return $this;
    }

    /**
     * Validate solution against custom business validation rules.
     *
     * @return $this
     */
    public function validate(): self
    {
        $this->storeSolution();

        $this->solutionValidationService
            ->setSolution($this->solution)
            ->setProblem($this->problem)
            ->validateCharsCount()
            ->validateLanguageUsed();

        $this->updateSolution(['status' => SolutionStatusType::VALIDATED]);

        return $this;
    }

    /**
     * Delegate execution of problem tests to CodeExecutorService,
     * which can be used as abstraction / adapter for many different
     * external code compilation & execution services.
     */
    public function delegateExecution(): void
    {
        $this->codeExecutorService
            ->init()
            ->executeSolution($this->solution);

        $this->updateSolution(['status' => SolutionStatusType::DELEGATED]);
    }

    /**
     * Store solution record in the database.
     */
    private function storeSolution(): void
    {
        $this->solution = $this->problem
            ->solutions()
            ->create($this->solutionData);
    }

    /**
     * Update solution database record using concrete repository.
     *
     * @param array $data
     */
    private function updateSolution(array $data): void
    {
        $this->solution = $this->solutionRepository->update(
            $this->solution,
            $data
        );
    }
}
