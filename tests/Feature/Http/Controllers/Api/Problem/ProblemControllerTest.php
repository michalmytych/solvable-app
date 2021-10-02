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

    public function testReturnsListOfProblemsByUserFromAllRoute()
    {
        $this->markTestSkipped();
        // todo
    }

    public function testCanStoreProblemThroughStoreRoute()
    {
        $this->markTestSkipped();
        // todo
    }

    public function testReturnsProblemFromFindRoute()
    {
        $this->markTestSkipped();
        // todo
    }
}
