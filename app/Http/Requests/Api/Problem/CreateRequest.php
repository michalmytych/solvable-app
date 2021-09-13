<?php

namespace App\Http\Requests\Api\Problem;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            //
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
