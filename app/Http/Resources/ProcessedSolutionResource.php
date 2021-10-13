<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProcessedSolutionResource extends JsonResource
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
            'id' => $this->id,
            'problem_id' => $this->problem_id,
            'code_language_id' => $this->code_language_id,
            'code' => $this->code,
            'characters' => $this->characters,
            'problem_chars_limit' => $this->problem->chars_limit,
            'status' => $this->status,
            'score' => $this->score,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
