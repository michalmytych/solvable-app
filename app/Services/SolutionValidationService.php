<?php

namespace App\Services;

use App\Enums\SolutionStatusType;
use App\Models\Problem;
use App\Models\Solution;
use Illuminate\Validation\ValidationException;

class SolutionValidationService
{
    private Solution $solution;

    private Problem $problem;

    /**
     * Set solution instance to validate.
     *
     * @param Solution $solution
     * @return $this
     */
    public function setSolution(Solution $solution): self
    {
        $this->solution = $solution;

        return $this;
    }

    /**
     * Set problem to get validation rules.
     *
     * @param Problem $problem
     * @return $this
     */
    public function setProblem(Problem $problem): self
    {
        $this->problem = $problem;

        return $this;
    }

    /**
     * Validate solution code characters count against
     * characters limit provided in problem instance.
     *
     * @return $this
     */
    public function validateCharsCount(): self
    {
        $charactersCount = strlen($this->solution->code);

        if ($charactersCount > $this->problem->characters_limit) {
            $this->markSolutionAsInvalid(SolutionStatusType::CHARACTERS_LIMIT_EXCEEDED);

            ValidationException::withMessages([
                'errors' => [ 'solutions.validation.memory-limit-exceeded' ]
            ]);
        }

        $this->solution->update(['characters' => $charactersCount]);

        return $this;
    }

    /**
     * Validate if language related to solution
     * was allowed in provided problem.
     *
     * @return $this
     */
    public function validateLanguageUsed(): self
    {
        $chosenCodingLanguageId = strlen($this->solution->code_language_id);

        if (! optional($this->problem->codingLanguages)->contains('id', $chosenCodingLanguageId)) {
            $this->markSolutionAsInvalid(SolutionStatusType::INVALID_LANGUAGE_USED);

            ValidationException::withMessages([
                'errors' => [ 'solutions.validation.invalid-language-chosen' ]
            ]);
        }

        return $this;
    }

    /**
     * Mark status of processed as invalid.
     *
     * @param int $statusType
     */
    private function markSolutionAsInvalid(int $statusType = SolutionStatusType::INVALID): void
    {
        $this->solution = tap($this->solution)->update(['status' => $statusType]);
    }
}
