<?php

namespace Tests\Feature\Http\Controllers\Api\Problem\CodeLanguage;

use Tests\TestCase;
use App\Models\CodeLanguage;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Support\Auth\AuthenticatesTestRequests;

class CodeLanguageControllerTest extends TestCase
{
    use AuthenticatesTestRequests, RefreshDatabase;

    private array $codeLanguageJsonStructure = [
        'id'         => 'string',
        'name'       => 'string',
        'identifier' => 'string',
        'version'    => 'integer',
        'created_at' => 'string',
        'updated_at' => 'string',
    ];

    public function testReturnsAllCodeLanguages(): void
    {
        CodeLanguage::factory(3)->create();

        $this
            ->authenticate()
            ->getJson(route('api.code_language.all'))
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->count(3)
                ->each(fn(AssertableJson $json) => $json
                    ->whereAllType($this->codeLanguageJsonStructure)
                )
            );
    }
}