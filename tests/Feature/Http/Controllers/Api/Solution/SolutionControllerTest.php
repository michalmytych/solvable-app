<?php

namespace Tests\Feature\Http\Controllers\Api\Solution;

use GuzzleHttp\Psr7\Response;
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

    private CodeLanguage $codeLanguage;

    private array $solutionResourceJsonStructure;

    private array $solutionInCollectionJsonStructure;

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

        $this->mockJdoodleClient([
            new Response(
                200, ['Content-Type' => 'application/json'],
                json_encode([
                    'output' => '4',
                    'statusCode' => 200,
                    'memory' => 100,
                    'cpuTime' => 10
                ]))
        ]);
    }

    public function testReturnsListOfSolutionsByUserAndQueryFilters()
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

    public function testCommitExecutesSolutionCodeAndReturnsSolutionWhenExternalApiRespondsWithHttpOk()
    {
        $startSolutionsCount = Solution::where('user_id', $this->user->id)->count();
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
            Solution::where('user_id', $this->user->id)->count()
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

    public function testCommitReturnsUnprocessableOnIncompleteRequestData()
    {
        $problem = Problem::factory()->create();

        $this->solutionData['data'] = [
            'code' => null
        ];

        $response = $this
            ->actingAs($this->user)
            ->postJson(route('solution.commit', ['problem' => $problem->id]), $this->solutionData);

        $response
            ->assertStatus(422)
            ->assertJson(fn($json) => $json
                ->has('message')
                ->has('errors', 2)
            );
    }

    public function testCommitReturnsUnprocessableOnInvalidCodeStringDataProvided()
    {
        $startSolutionsCount = Solution::where('user_id', $this->user->id)->count();

        $problem = Problem::factory()->create();

        $this->solutionData['data']['code'] = '# &@ ID IIDII OID ____)()()(()';   // not a base 64 string

        $response = $this
            ->actingAs($this->user)
            ->postJson(route('solution.commit', ['problem' => $problem->id]), $this->solutionData);

        $this->assertEquals(
            $startSolutionsCount + 1,
            Solution::where('user_id', $this->user->id)->count()
        );

        unset($this->solutionResourceJsonStructure['executions']);

        $this->solutionResourceJsonStructure['characters'] = 'null';

        $response
            ->assertStatus(422)
            ->assertJson(fn($json) => $json
                ->has('message')
                ->has('errors', 1)
                ->has('data', fn($json) => $json
                    ->whereAllType($this->solutionResourceJsonStructure)
                    ->where('status', SolutionStatusType::MALFORMED_UTF8_CODE_STRING)
                )
            );
    }

    public function testCommitReturnsUnprocessableOnCharactersLimitExceeded()
    {
        $startSolutionsCount = Solution::where('user_id', $this->user->id)->count();

        $problem = Problem::factory()->create(['chars_limit' => 5]);

        $this->solutionData['data']['code'] = 'YXdmc2Nz';

        $response = $this
            ->actingAs($this->user)
            ->postJson(route('solution.commit', ['problem' => $problem->id]), $this->solutionData);

        $this->assertEquals(
            $startSolutionsCount + 1,
            Solution::where('user_id', $this->user->id)->count()
        );

        unset($this->solutionResourceJsonStructure['executions']);

        $response
            ->assertStatus(422)
            ->assertJson(fn($json) => $json
                ->has('message')
                ->has('errors', 1)
                ->has('data', fn($json) => $json
                    ->whereAllType($this->solutionResourceJsonStructure)
                    ->where('status', SolutionStatusType::CHARACTERS_LIMIT_EXCEEDED)
                    ->where('characters', 6)
                )
            );
    }

    public function testCommitReturnsUnprocessableOnNonAvailableLanguageChosen()
    {
        $startSolutionsCount = Solution::where('user_id', $this->user->id)->count();
        $problem = Problem::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->postJson(route('solution.commit', ['problem' => $problem->id]), $this->solutionData);

        $this->assertEquals(
            $startSolutionsCount + 1,
            Solution::where('user_id', $this->user->id)->count()
        );

        unset($this->solutionResourceJsonStructure['executions']);

        $response
            ->assertStatus(422)
            ->assertJson(fn($json) => $json
                ->has('message')
                ->has('errors', 1)
                ->has('data', fn($json) => $json
                    ->whereAllType($this->solutionResourceJsonStructure)
                    ->where('status', SolutionStatusType::INVALID_LANGUAGE_USED)
                )
            );
    }

    public function testCommitReturnsValidResponseOnExternalServiceInternalError()
    {
        $this->markTestSkipped();
        // todo
    }

    public function testReturnsSolutionByIdFromFindRoute()
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
