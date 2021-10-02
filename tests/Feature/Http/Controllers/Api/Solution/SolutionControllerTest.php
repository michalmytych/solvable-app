<?php

namespace Tests\Feature\Http\Controllers\Api\Solution;

use Tests\TestCase;
use App\Models\User;
use App\Models\Problem;
use App\Models\Solution;
use App\Models\Execution;
use App\Models\CodeLanguage;
use App\Enums\SolutionStatusType;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Support\CodeExecutor\Traits\MocksJdoodleClient;

class SolutionControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker, MocksJdoodleClient;

    private User $user;

    private array $solutionData;

    private array $solutionResourceJsonStructure;

    private array $solutionInCollectionJsonStructure;

    private CodeLanguage $codeLanguage;

    /**
     * Set up test case.
     * @noinspection PhpFieldAssignmentTypeMismatchInspection
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->codeLanguage = CodeLanguage::factory()->create([
            'name' => 'Python 3.7.4',
            'identifier' => 'python3',
            'version' => 3,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        $this->solutionResourceJsonStructure = [
            'id' => 'string',
            'problem_id' => 'string',
            'code_language_id' => 'string',
            'code' => 'string',
            'score' => ['integer', 'null'],
            'problem_chars_limit' => 'integer',
            'characters' => 'integer',
            'status' => 'integer',
            'created_at' => 'string',
            'updated_at' => 'string',
            'executions' => 'array'
        ];

        $this->solutionInCollectionJsonStructure = [
            'id' => 'string',
            'problem_id' => 'string',
            'code_language_id' => 'string',
            'status' => 'integer',
            'created_at' => 'string',
            'updated_at' => 'string'
        ];

        $this->solutionData = [
            'data' => [
                'code' => base64_encode('print(int(input()) + int(input()))'),
                'code_language_id' => $this->codeLanguage->id
            ]
        ];

        $this->user = User::factory()->create();
    }

    public function test_returns_list_of_solutions_by_user_and_query_filters()
    {
        $this->markTestSkipped();

        $cpp = CodeLanguage::factory()->create();
        $java = CodeLanguage::factory()->create();

        $firstProblem = Problem::factory()->create();
        $secondProblem = Problem::factory()->create();

        Solution::factory()
            ->create([
                'user_id' => $this->user->id,
                'code_language_id' => $cpp->id,
                'problem_id' => $firstProblem->id,
                'status' => SolutionStatusType::INVALID
            ]);

        Solution::factory()
            ->create([
                'user_id' => $this->user->id,
                'code_language_id' => $java->id,
                'problem_id' => $firstProblem->id,
                'status' => SolutionStatusType::INVALID
            ]);

        Solution::factory()
            ->create([
                'user_id' => $this->user->id,
                'code_language_id' => $java->id,
                'problem_id' => $secondProblem->id,
            ]);

        Solution::factory()
            ->create([
                'user_id' => $this->user->id
            ]);

        $response = $this
            ->actingAs($this->user)
            ->getJson(route('solution.all'));

        $response
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->has('data', fn(AssertableJson $json) => $json
                    ->count(Solution::where('user_id', $this->user->id)->count())
                    ->each(fn(AssertableJson $json) => $json
                        ->whereAllType($this->solutionInCollectionJsonStructure)
                    )
                )
                ->etc()
            );

        $response = $this
            ->actingAs($this->user)
            ->getJson(route('solution.all', ['code_language_id' => $java->id]));

        $response
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->has('data', fn(AssertableJson $json) => $json
                    ->count(Solution::where([
                        'user_id' => $this->user->id,
                        'code_language_id' => $java->id
                    ])->count())
                    ->each(fn(AssertableJson $json) => $json
                        ->whereAllType($this->solutionInCollectionJsonStructure)
                    )
                )
                ->etc()
            );

        $response = $this
            ->actingAs($this->user)
            ->getJson(route(
                'solution.all',
                ['code_language_id' => $java->id, 'status' => SolutionStatusType::INVALID]
            ));

        $response
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->has('data', fn(AssertableJson $json) => $json
                    ->count(Solution::where([
                        'user_id' => $this->user->id,
                        'code_language_id' => $java->id,
                        'status' => SolutionStatusType::INVALID
                    ])->count())
                    ->each(fn(AssertableJson $json) => $json
                        ->whereAllType($this->solutionInCollectionJsonStructure)
                    )
                )
                ->etc()
            );

        $response = $this
            ->actingAs($this->user)
            ->getJson(route('solution.all', ['problem_id' => $secondProblem->id]));

        $response
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->has('data', fn(AssertableJson $json) => $json
                    ->count(Solution::where([
                        'user_id' => $this->user->id,
                        'problem_id' => $secondProblem->id
                    ])->count())
                    ->each(fn(AssertableJson $json) => $json
                        ->whereAllType($this->solutionInCollectionJsonStructure)
                    )
                )
                ->etc()
            );

        $response = $this
            ->actingAs($this->user)
            ->getJson(route(
                'solution.all',
                ['code_language_id' => $java->id, 'status' => SolutionStatusType::INVALID_LANGUAGE_USED]
            ));

        $response
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->has('data', fn(AssertableJson $json) => $json->count(0))
                ->etc()
            );
    }

    public function test_commit_executes_solution_code_and_returns_solution_when_external_api_responds_with_http_ok()
    {
        $startSolutionsCount = Solution::count();
        $startExecutionsCount = Execution::count();
        $problem = Problem::factory()->create();

        $problem
            ->codeLanguages()
            ->save($this->codeLanguage);

        $response = $this
            ->actingAs($this->user)
            ->postJson(route('solution.commit', ['problem' => $problem->id]), $this->solutionData);

        $this->assertEquals(
            $startSolutionsCount + 1,
            Solution::count()
        );

        $this->assertEquals(
            $startExecutionsCount + $problem->tests()->count(),
            Execution::count()
        );

        $processedSolutionJsonStructure = $this->solutionResourceJsonStructure;

        unset($processedSolutionJsonStructure['executions']);

        $response
            ->assertStatus(202)
            ->assertJson(fn($json) => $json
                ->has('message')
                ->has('data', fn($json) => $json
                    ->whereAllType($processedSolutionJsonStructure))
            );
    }

    public function test_returns_solution_by_id_from_find_route()
    {
        $solution = Solution::first() ?? Solution::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->getJson(route('solution.find', ['solution' => $solution->id]));

        $response
            ->assertStatus(200)
            ->assertJson(fn($json) => $json
                ->has('data', fn($json) => $json
                    ->whereAllType($this->solutionResourceJsonStructure))
            );
    }
}
