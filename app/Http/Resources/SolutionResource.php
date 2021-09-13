<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolutionResource extends JsonResource
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
            'execution_time' => $this->execution_time,
            'memory_used' => $this->memory_used,
            'characters' => $this->characters,
            'problem_chars_limit' => $this->problem->chars_limit,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'executions' => $this->executions->map(function ($execution) {
                return [
                  'execution_time' => $execution->execution_time,
                    'memory_used' => $execution->memory_used,
                    'output' => $execution->output,
                    'passed' => $execution->passed,
                    'test' => [
                        'input' => $execution->test->input,
                        'valid_outputs' => $execution->test->valid_outputs,
                        'time_limit' => $execution->test->time_limit,
                        'memory_limit' => $execution->test->memory_limit
                    ],
                ];
            })
        ];
    }
}
