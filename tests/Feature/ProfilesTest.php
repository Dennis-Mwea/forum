<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfilesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test that a user has a profile
     * @test
     */
    public function aUserHasAProfile()
    {
        $user = create(User::class);

        $this->get("/profiles/{$user->name}")
            ->assertSee($user->name);
    }
}
