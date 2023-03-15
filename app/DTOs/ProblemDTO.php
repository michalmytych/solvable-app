<?php

namespace App\DTOs;

use Spatie\LaravelData\DataCollection;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\LaravelData\Attributes\DataCollectionOf;

class ProblemDTO extends DTO
{
    public function __construct(
        public readonly ?string $id,
        public readonly string $title,
        public readonly string $content,
        public readonly int $chars_limit,
        public readonly ?string $group_id,
        public readonly ?string $course_id,
        public readonly string $user_id,
        public readonly array $code_languages_ids,
               #[DataCollectionOf(TestDTO::class)]
        public readonly DataCollection $tests
    ) {
    }

    public static function fromRequest(FormRequest $request): ProblemDTO
    {
        // @todo czy to powinno tu być?
        $formData = $request->validated();
        data_set($formData, 'user_id', $request->user()->id);

        $testsJson = data_get($formData, 'tests_json_data');
        data_set($formData, 'tests', json_decode($testsJson));

        return ProblemDTO::from($formData);
    }
}