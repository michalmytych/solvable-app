<?php

namespace Tests\Feature\Support\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * @method actingAs(Authenticatable $user, $guard = null)
 */
trait AuthenticatesTestRequests
{
    protected User $user;

    /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
    public function setUpUser(): void
    {
        $this->user = User::factory()->create();
    }

    protected function authenticate(): TestCase
    {
        return $this->actingAs($this->user);
    }
}