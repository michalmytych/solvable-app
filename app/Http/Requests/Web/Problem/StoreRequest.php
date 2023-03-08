<?php

namespace App\Http\Requests\Web\Problem;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HasJsonFailedValidationResponse;

class StoreRequest extends FormRequest
{
    use HasJsonFailedValidationResponse;

    public function rules(): array
    {
        return [
            'title'                 => 'required|string',
            'tests'                 => 'required_without:tests_json_data|array',
            'tests.*.input'         => 'required|string',
            'tests.*.time_limit'    => 'required|memory_limit',
            'tests.*.memory_limit'  => 'required|integer',
            'tests.*.valid_outputs' => 'required|array',
            'tests_json_data'       => 'required_without:tests|json',
            'content'               => 'required|string',
            'group_id'              => 'nullable|string|exists:groups,id',
            'course_id'             => 'nullable|string|exists:courses,id',
            'chars_limit'           => 'required|integer',
            'code_languages_ids'    => 'array',
        ];
    }
}
