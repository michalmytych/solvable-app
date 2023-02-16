<?php

namespace App\Services;

use App\Models\Problem;
use App\Models\Solution;
use App\Enums\SolutionStatusType;
use Illuminate\Validation\ValidationException;

class SolutionValidationService
{
    private Problem $problem;

    private Solution $solution;

    /**
     * Set solution instance to validate.
     */
    public function setSolution(Solution $solution): self
    {
        $this->solution = $solution;

        return $this;
    }

    /**
     * Set problem to get validation rules.
     */
    public function setProblem(Problem $problem): self
    {
        $this->problem = $problem;

        return $this;
    }

    /**
     * Validate if language related to solution
     * was allowed in provided problem.
     * @throws ValidationException
     */
    public function validateLanguageUsed(array $data): self
    {
        if (!$this->problem->codeLanguages->contains($data['code_language_id'])) {
            $this->updateSolution(['status' => SolutionStatusType::INVALID_LANGUAGE_USED->value]);

            throw ValidationException::withMessages([
                'errors' => ['code_language_id' => 'solutions.validation.invalid-language-chosen']
            ]);
        }

        return $this;
    }

    /**
     * Validate solution code characters count against
     * characters limit provided in problem instance.
     * @throws ValidationException
     */
    public function validateCharsCount(array $data): self
    {
        $charactersCount = strlen($data['code']);

        if ($charactersCount > $this->problem->chars_limit) {
            $this->updateSolution([
                'status' => SolutionStatusType::CHARACTERS_LIMIT_EXCEEDED->value,
                'characters' => $charactersCount
            ]);

            throw ValidationException::withMessages([
                'errors' => ['code' => 'solutions.validation.characters-limit-exceeded']
            ]);
        }

        $this->updateSolution(['characters' => $charactersCount]);

        return $this;
    }

    /**
     * Validate if provided encoded programming language code data is valid.
     * @throws ValidationException
     */
    public function validateCodeString(array $data): self
    {
        if (!$data['code']) {
            $this->updateSolution([
                'status' => SolutionStatusType::EMPTY_DECODING_RESULT->value,
                'code' => 'data-placeholder.empty-decoding-result'
            ]);

            throw ValidationException::withMessages([
                'errors' => ['code' => 'solution.errors.invalid-code-data-provided.empty-decoding-result']
            ]);
        }

        if (!mb_check_encoding($data['code'], 'UTF-8')) {
            $this->updateSolution([
                'status' => SolutionStatusType::MALFORMED_UTF8_CODE_STRING->value,
                'code' => 'data-placeholder.solution-code-data-was-malformed'
            ]);

            throw ValidationException::withMessages([
                'errors' => ['code' => 'solution.errors.invalid-code-data-provided.malformed-utf8-string']
            ]);
        }

        return $this;
    }

    /**
     * Update solution status to received.
     */
    public function markReceived(): self
    {
        $this->updateSolution(['status' => SolutionStatusType::RECEIVED->value]);

        return $this;
    }

    /**
     * Update solution record at database.
     */
    public function updateSolution(array $data): self
    {
        $this->solution = tap($this->solution)->update($data);

        return $this;
    }
}
