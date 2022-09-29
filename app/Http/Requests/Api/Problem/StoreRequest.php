<?php

namespace App\Http\Requests\Api\Problem;

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
            'title' => 'string|max:96',
            'content' => 'string|max:1028'
        ];
    }
}
