<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
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

        $this->thread = factory(Thread::class)->create();
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
        $reply = factory(Reply::class)->create(['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }
}
