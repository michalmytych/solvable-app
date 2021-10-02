<?php

namespace App\Jobs;

use App\Models\Solution;
use Illuminate\Bus\Queueable;
use App\Enums\SolutionStatusType;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FinishSolutionProcessing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private Solution $solution)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $passed = $this->getSolutionStatusByTestsExecutionsResults();

        $this->solution = tap($this->solution)->update([
            'status' => $passed ? SolutionStatusType::PASSED_ALL_TESTS : SolutionStatusType::FAILED_TESTS
        ]);
    }

    /**
     * Return true, if all tests of solution succeeded,
     * in other cases return false.
     *
     * @return bool
     */
    private function getSolutionStatusByTestsExecutionsResults(): bool
    {
        return $this->solution
            ->problem
            ->tests
            ->map(fn ($test) => $test->executions->firstWhere('solution_id', $this->solution->id))
            ->every(fn ($execution) => optional($execution)->passed);
    }
}
