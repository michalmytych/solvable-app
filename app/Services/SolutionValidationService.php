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

    public function setSolution(Solution $solution): self
    {
        $this->solution = $solution;

        return $this;
    }

    public function setProblem(Problem $problem): self
    {
        $this->problem = $problem;

        return $this;
    }

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

    private function markSolutionAsInvalid(int $statusType): void
    {
        $this->solution = tap($this->solution)->update(['status' => $statusType]);
    }
}
