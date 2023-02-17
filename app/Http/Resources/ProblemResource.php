<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProblemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'title'          => $this->title,
            'content'        => $this->content,
            'chars_limit'    => $this->chars_limit,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
            'tests'          => $this->tests->isNotEmpty()
                ? $this->tests->map(fn($test) => [
                    'input'         => $test->input,
                    'valid_outputs' => $test->valid_outputs,
                    'time_limit'    => $test->time_limit,
                    'memory_limit'  => $test->memory_limit,
                ])
                : [],
            'code_languages' => $this->codeLanguages->isNotEmpty()
                ? $this->codeLanguages->map(fn($language) => [
                    'id'                  => $language->id,
                    'name'                => $language->name,
                    'external_identifier' => $language->identifier,
                ])
                : [],
        ];
    }
}
