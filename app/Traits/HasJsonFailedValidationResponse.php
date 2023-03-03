<?php

namespace App\Traits;

use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait HasJsonFailedValidationResponse
{
    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator): RedirectResponse
    {
        $errors = (new ValidationException($validator))->errors();

        if (request()->wantsJson()) {
            throw new HttpResponseException(
                response()->json([
                    'errors' => $errors,
                    'message' => 'validation.failed'
                ], Response::HTTP_UNPROCESSABLE_ENTITY)
            );
        }

        return redirect()->back()->with('errors');
    }
}
