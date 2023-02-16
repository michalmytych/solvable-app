<?php

namespace App\Http\Requests\Api\Group;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'string|max:96',
            'description' => 'string',
            'problems_ids' => 'present|nullable|array'
        ];
    }
}
