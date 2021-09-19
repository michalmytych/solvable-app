<?php

namespace Tests\Feature\Http\Controllers\Api\Problem;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;

class ProblemControllerTest extends TestCase
{
    use WithFaker;

    private User $user;

    private array $problemData;

    private array $problemResourceJsonStructure;

    private array $problemInCollectionJsonStructure;

    /**
     * Set up test case.
     * @noinspection PhpFieldAssignmentTypeMismatchInspection
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->problemResourceJsonStructure = [
            'title' => 'string',
            'content' => 'string',
            'chars_limit' => 'integer',
            'created_at' => 'string',
            'updated_at' => 'string',
            'tests' => 'array',
            'code_languages' => 'array'
        ];

        $this->problemInCollectionJsonStructure = [
            'title' => 'string'
        ];

        $this->problemData = [
            'title' => 'Some new problem title',
            'name' => $this->faker->realText(256)
        ];

        $this->user = User::factory()->create();
    }

    public function test_returns_list_of_problems_by_user_from_all_route()
    {
        $this->markTestSkipped();
        // todo
    }

    public function test_can_store_problem_through_store_route()
    {
        $this->markTestSkipped();
        // todo
    }

    public function test_returns_problem_from_find_route()
    {
        $this->markTestSkipped();
        // todo
    }
}
