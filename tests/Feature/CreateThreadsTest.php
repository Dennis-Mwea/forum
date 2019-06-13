<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\Channel;
use Tests\TestCase;
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
        $this->withExceptionHandling()
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

        $response = $this->post('/threads', $thread->toArray());

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
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /**
     * Test whether post request is validated
     * @test
     */
    public function aThreadRequiresABody()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /**
     * Test whether post request is validated
     * @test
     */
    public function aThreadRequiresAValidChannel()
    {
        factory(Channel::class, 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');
        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /**
     * Test whether a thread can be deleted
     * @test
     */
    public function guestsCannotBeDeleteThreads()
    {
        $this->withExceptionHandling();
        
        $thread = create(Thread::class);

        $response = $this->delete($thread->path());

        $response->assertRedirect('/login');
    }

    /**
     * Test whether a thread can be deleted
     * @test
     */
    public function aThreadCanBeDeleted()
    {
        $this->signIn();
        $thread = create(Thread::class);
        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());
        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make(Thread::class, $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
