<?php /** @noinspection PhpFieldAssignmentTypeMismatchInspection */

namespace App\Services;

use App\Models\Problem;
use App\Models\Solution;
use App\Enums\SolutionStatusType;
use App\Repositories\SolutionRepository;
use App\Contracts\CodeExecutor\CodeExecutorServiceInterface;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

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
        $this->solutionData = $this->decodeSolutionCodeFromBase($data);

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
     * which can be used as abstraction / adapter for many
     * external code compilation & execution services.
     */
    public function delegateExecution(): self
    {
        $this->codeExecutorService
            ->init()
            ->executeSolution($this->solution);

        $this->updateSolution(['status' => SolutionStatusType::DELEGATED]);

        return $this;
    }

    /**
     * Return currently processed solution model.
     *
     * @return Solution
     */
    public function getProcessedSolution(): Solution
    {
        return $this->solution;
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
     * Decode stored solution code data from base 64 to string,
     * throw validation error if provided code data is invalid.
     *
     * @param array $data
     * @return array
     */
    private function decodeSolutionCodeFromBase(array $data): array
    {
        $data['code'] = base64_decode($data['code']);

        if (!$data['code']) {
            ValidationException::withMessages([
                'errors' => [ 'code' => 'solution.errors.invalid-code-data-provided' ]
            ]);
        }

        return $data;
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
