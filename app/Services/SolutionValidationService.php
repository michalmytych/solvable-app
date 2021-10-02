<?php

namespace App\Services;

use App\Models\Problem;
use App\Models\Solution;
use App\Enums\SolutionStatusType;
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
     * @throws ValidationException
     */
    public function validateCharsCount(): self
    {
        $charactersCount = strlen($this->solution->code);

        if ($charactersCount > $this->problem->chars_limit) {
            $this->updateSolution([
                'status' => SolutionStatusType::CHARACTERS_LIMIT_EXCEEDED,
                'characters' => $charactersCount
            ]);

            throw ValidationException::withMessages([
                'errors' => ['code' => 'solutions.validation.characters-limit-exceeded']
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
     * @throws ValidationException
     */
    public function validateLanguageUsed(): self
    {
        if (!$this->problem->codeLanguages->contains($this->solution->code_language_id)) {
            $this->updateSolution(['status' => SolutionStatusType::INVALID_LANGUAGE_USED]);

            throw ValidationException::withMessages([
                'errors' => ['code_language_id' => 'solutions.validation.invalid-language-chosen']
            ]);
        }

        return $this;
    }

    /**
     * Validate if provided encoded programming language code data is valid.
     *
     * @param array $data
     * @throws ValidationException
     */
    public function validateCodeString(array &$data): void
    {
        if (!$data['code']) {
            $data['status'] = SolutionStatusType::INVALID_SOLUTION_CODE_DATA;

            throw ValidationException::withMessages([
                'errors' => ['code' => 'solution.errors.invalid-code-data-provided.empty-data']
            ]);
        }

        if (!mb_check_encoding($data['code'], 'UTF-8')) {
            $data['status'] = SolutionStatusType::MALFORMED_UTF8_CODE_STRING;

            throw ValidationException::withMessages([
                'errors' => ['code' => 'solution.errors.invalid-code-data-provided.malformed-utf8-string']
            ]);
        }
    }

    /**
     * Update solution record at database.
     *
     * @param array $data
     */
    private function updateSolution(array $data): void
    {
        $this->solution = tap($this->solution)->update($data);
    }
}
