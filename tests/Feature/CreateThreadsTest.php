<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\Channel;
use App\Activity;
use Tests\TestCase;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test whether unauthenticated users can create threads
     * @test
     */
    public function unAuthenticatedUsersCannotCreateNewThreads()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->withExceptionHandling()
            ->post('/threads', [])
            ->assertRedirect('/login');
    }

    /**
     * Test whether authenticated users can create threads
     * @test
     */
    public function anAuthenticatedUserCanCreateANewThread()
    {
        $this->signIn();

        $thread = make(Thread::class);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /**
     * Test whether post request is validated
     * @test
     */
    public function aThreadRequiresATitle()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /**
     * Test whether post request is validated
     * @test
     */
    public function aThreadRequiresABody()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /**
     * Test whether post request is validated
     * @test
     */
    public function aThreadRequiresAValidChannel()
    {
        factory(Channel::class, 2)->create();

        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');
        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /**
     * Test whether a thread can be deleted
     * @test
     */
    public function unauthorizedUsersCannotBeDeleteThreads()
    {
        $this->withExceptionHandling();

        $thread = create(Thread::class);

        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->delete($thread->path())
            ->assertRedirect('/login');

        $this->signIn();
        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->delete($thread->path())
            ->assertStatus(403);
    }

    /**
     * Test whether a thread can be deleted
     * @test
     */
    public function authorizedUsersCanDeleteThreads()
    {
        $this->signIn();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->json('DELETE', $thread->path());
        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, Activity::count());
    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make(Thread::class, $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
