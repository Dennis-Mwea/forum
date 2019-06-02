<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\Channel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
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
      * Test whether a user can view all threads
      * @test
      */
    public function aUserCanViewAllThreads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title)
            ->assertSee($this->thread->body);
    }

    /**
     * Test whether a user can view a single thread
     * @test
     */
    public function aUserCanReadASingleThread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title)
            ->assertSee($this->thread->body);
    }

    /**
     * Test whether a user can view replies associated with a single thread
     * @test
     */
    public function aUserCanReadThreadsAssociatedWithAThread()
    {
        $reply = create('App\Reply', ['thread_id' => $this->thread->id]);
        
        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /**
     * Test whether a user can filter threads by channel name
     * @test
     */
    public function aUserCanFilterThreadsByTag()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }
}
