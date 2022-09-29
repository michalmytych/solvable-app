<?php

namespace App\Http\Requests\Api\Problem;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'tests' => 'present|array',
            'tests.*.input' => 'required|string',
            'tests.*.time_limit' => 'required|memory_limit',
            'tests.*.memory_limit' => 'required|integer',
            'tests.*.valid_outputs' => 'required|array',
            'content' => 'required|string',
            'group_id' => 'nullable|string|exists:groups',
            'course_id' => 'nullable|string|exists:courses',
            'chars_limit' => 'required|integer',
            'code_languages_ids' => 'array'
        ];
    }

    /**
     * Messages to return when validation fails.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            //
        ];
    }
}
