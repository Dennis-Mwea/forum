<?php

namespace Tests\Feature;

use App\User;
use App\Thread;
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

        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->get("/profiles/{$user->name}")
            ->assertSee($user->name);
    }

    /**
     * Test that a user profile's page has all his threads
     * @test
     */
    public function profilesDisplayAllThreadsCreatedByTheAssociatedUser()
    {
        $this->signIn($user = create(User::class));
        $thread = create(Thread::class, ['user_id' => $user->id]);

        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->get("/profiles/{$user->name}")
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
