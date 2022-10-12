<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Routing\Middleware\ThrottleRequests;

class UserControllerTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(
            ThrottleRequests::class
        );

        $this->userData = [
            'name' => $this->faker->userName,
            'email' => $this->faker->email,
            'password' => 'some password',
            'password_confirmation' => 'some password'
        ];
    }

    public function testItRegistersNewUserIfInputIsValid()
    {
        $tokensCount = DB::table('personal_access_tokens')->count();

        $response = $this->post(
            route('register'),
            $this->userData
        );

        $response
            ->assertCreated()
            ->assertJson(fn(AssertableJson $json) => $json
                ->has('user', fn($json) => $json
                    ->where('name', $this->userData['name'])
                    ->where('email', $this->userData['email'])
                    ->has('created_at')
                    ->has('updated_at')
                )
                ->has('token')
            );

        $responseData = collect(json_decode($response->content()));

        $user = User::firstWhere('email', $this->userData['email']);

        $this->assertNotNull($user);

        $this->assertTrue(
            Hash::check($this->userData['password'], $user->password)
        );

        $this->assertDatabaseCount('personal_access_tokens', $tokensCount + 1);
    }

    public function testRegisterRouteReturns422WhenInputIsInvalid()
    {
        $response = $this->post(route('register'), []);

        $response
            ->assertStatus(422)
            ->assertJson(fn($json) => $json
                ->has('message')
                ->has('errors', 3)
            );
    }

    public function testItLogsInNewUserIfInputIsValid()
    {
        $tokensCount = DB::table('personal_access_tokens')->count();

        $registerResponse = $this->post(
            route('register'),
            $this->userData
        );

        $registerResponse
            ->assertCreated();

        $this->assertDatabaseCount('personal_access_tokens', $tokensCount + 1);

        $loginResponse = $this->post(
            route('login'),
            $this->userData
        );

        $loginResponse
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->has('user', fn($json) => $json
                    ->where('name', $this->userData['name'])
                    ->where('email', $this->userData['email'])
                    ->has('email_verified_at')
                    ->has('created_at')
                    ->has('updated_at')
                )
                ->has('token')
            );

        $this->assertDatabaseCount('personal_access_tokens', $tokensCount + 2);
    }

    public function testLoginRouteReturns422WhenInputIsInvalid()
    {
        $response = $this->post(route('login'), []);

        $response
            ->assertStatus(422)
            ->assertJson(fn($json) => $json
                ->has('message')
                ->has('errors', 2)
            );
    }

    public function testLogoutRouteIsProtected()
    {
        $response = $this
            ->postJson(route('logout'));

        $response
            ->assertUnauthorized()
            ->assertJson(fn($json) => $json
                ->where('message', 'Unauthenticated.')
            );

        $response = $this
            ->post(route('logout'));

        $response->assertRedirect();
    }

    public function testItLogsOutUserOnRequestWhenLoggedIn()
    {
        $tokensCount = DB::table('personal_access_tokens')->count();

        $registeResponse = $this->post(
            route('register'),
            $this->userData
        );

        $registeResponse
            ->assertCreated();

        $this->assertDatabaseCount('personal_access_tokens', $tokensCount + 1);

        $this->post(
            route('login'),
            $this->userData
        );

        $registeResponse
            ->assertCreated();

        $this->assertDatabaseCount('personal_access_tokens', $tokensCount + 2);

        $user = User::firstWhere('email', $this->userData['email']);

        $response = $this
            ->actingAs($user)
            ->post(route('logout'));

        $response
            ->assertOk()
            ->assertJson(fn($json) => $json
                ->has('message')
            );

        $this->assertDatabaseCount('personal_access_tokens', $tokensCount);
    }
}
