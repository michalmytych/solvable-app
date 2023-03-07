<?php

namespace App\Http\Requests\Web\Problem;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
//            'tests' => 'present|array',
//            'tests.*.input' => 'required|string',
//            'tests.*.time_limit' => 'required|memory_limit',
//            'tests.*.memory_limit' => 'required|integer',
//            'tests.*.valid_outputs' => 'required|array',
            'content' => 'required|string',
            'group_id' => 'nullable|string|exists:groups,id',
            'course_id' => 'nullable|string|exists:courses,id',
            'chars_limit' => 'required|integer',
            'code_languages_ids' => 'array'
        ];
    }
}
