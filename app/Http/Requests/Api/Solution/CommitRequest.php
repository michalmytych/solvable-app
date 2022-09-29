<?php

namespace App\Http\Requests\Api\Solution;

use Illuminate\Foundation\Http\FormRequest;

class CommitRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'data' => 'present',
            'data.code' => 'required|string',
            'data.code_language_id' => 'required|string|exists:code_languages,id'
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
            'data.code_language_id.exists' => 'Code language of this id does not exist in database.'
        ];
    }
}
