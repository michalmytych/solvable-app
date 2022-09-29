<?php

namespace App\Http\Requests\Api\Course;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HasJsonFailedValidationResponse;

class StoreRequest extends FormRequest
{
    use HasJsonFailedValidationResponse;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'string|unique',     // todo unique against other courses of this user
            'description' => 'string'
        ];
    }
}
