<?php

namespace Tests;

use Tests\Feature\Support\Auth\AuthenticatesTestRequests;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * @method setUpUser()
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUpTraits()
    {
        $uses = parent::setUpTraits();

        if (isset($uses[AuthenticatesTestRequests::class])) {
            $this->setUpUser();
        }
    }
}
