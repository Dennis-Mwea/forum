<?php

namespace Tests\Feature;

use App\User;
use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Thread variable
     *
     * @var object
     */
    protected $thread;

    /**
     * Test whether unauthenticated users add a reply to a thread
     * @test
     */
    public function unauthenticatedUsersMayNotParticipateInTheForum()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('/threads/1/replies', []);
    }

    /**
     * Thest that authenticated users can reply to thread posts.
     * @test
     */
    public function anAuthenticatedUserCanParticipateInForumThreads()
    {
        $this->be($user = factory(User::class)->create());

        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->make();

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
