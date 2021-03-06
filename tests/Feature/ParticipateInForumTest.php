<?php

namespace Tests\Feature;

use App\User;
use App\Reply;
use App\Thread;
use Tests\TestCase;
use App\Http\Middleware\VerifyCsrfToken;
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

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = create(Thread::class);
    }

    /**
     * Test whether unauthenticated users add a reply to a thread
     * @test
     */
    public function unauthenticatedUsersMayNotParticipateInTheForum()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->withExceptionHandling()
            ->post($this->thread->path() . '/replies', [])
            ->assertRedirect('/login');
    }

    /**
     * Thest that authenticated users can reply to thread posts.
     * @test
     */
    public function anAuthenticatedUserCanParticipateInForumThreads()
    {
        $this->signIn();

        $reply = make(Reply::class);

        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post($this->thread->path() . '/replies', $reply->toArray());

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /**
     * Test whether a reply's body is valie
     * @test
     */
    public function aReplyRequiresABody()
    {
        $this->withExceptionHandling()->signIn();

        $reply = make(Reply::class, ['body' => null]);

        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post($this->thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
