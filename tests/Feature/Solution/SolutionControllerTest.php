<?php

namespace Tests\Feature\Solution;

use Tests\TestCase;
use App\Models\User;
use App\Models\Problem;
use App\Models\Solution;
use App\Models\Execution;
use App\Models\CodeLanguage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SolutionControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private User $user;

    private array $solutionData;

    /**
     * Set up test case.
     * @noinspection PhpFieldAssignmentTypeMismatchInspection
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->solutionData = [
            'data' => [
                'code' => base64_encode($this->faker->realTextBetween(150, 960)),
                'code_language_id' => CodeLanguage::first()->id
            ]
        ];

        $this->user = User::factory()->create();
    }

    public function test_returns_list_of_solutions_by_problem()
    {
        $response = $this
            ->actingAs($this->user)
            ->get(
                route('solution.all_by_problem',
                    ['problem' => Problem::first()->id])
            );

        $response
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->has('data.0', fn($json) => $json
                    ->whereAllType([
                        'id' => 'string',
                        'user_id' => 'integer',
                        'problem_id' => 'string',
                        'code_language_id' => 'string',
                        'code' => 'string',
                        'score' => 'integer',
                        'execution_time' => 'integer',
                        'memory_used' => 'integer',
                        'characters' => 'integer',
                        'status' => 'integer',
                        'created_at' => 'string',
                        'updated_at' => 'string'
                    ])
                )
            );
    }

    public function test_commit_executes_solution_code_and_returns_solution()
    {
        $startSolutionsCount = Solution::query()->count();
        $startExecutionsCount = Execution::query()->count();
        $problem = Problem::first();

        $response = $this
            ->actingAs($this->user)
            ->post(
                route('solution.commit',
                    ['problem' => $problem->id]),
                $this->solutionData
            );

        $externalServiceConfigured = collect(config('services.external-compiler-client'))->every(fn($e) => $e);

        if (!$externalServiceConfigured) {
            print_r('<msg> Maybe you forgot to set external compiler service credentials in config?');

            return;
        }

        $this->assertEquals(
            $startSolutionsCount + 1,
            Solution::query()->count()
        );

        $this->assertEquals(
            $startExecutionsCount + $problem->tests()->count(),
            Execution::query()->count()
        );

        $response
            ->assertStatus(202)
            ->assertJson(fn($json) => $json
                ->has('message')
                ->has('data', fn($json) => $json
                    ->whereAllType([
                        'id' => 'string',
                        'code' => 'string',
                        'created_at' => 'string',
                        'characters' => 'integer',
                        'code_language' => 'array'
                    ]))
            );
    }
}
