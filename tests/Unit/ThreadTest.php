<?php

namespace Tests\Unit;

use App\User;
use App\Thread;
use App\Channel;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
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
     * Test that a thread has a creator
     * @test
     */
    public function aThreadHasACreator()
    {
        $this->assertInstanceOf(User::class, $this->thread->user);
    }

    /**
     * Test that a thread has replies
     * @test
     */
    public function aThreadHasReplies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /**
     * Test whether a thread can add a reply
     * @test
     */
    public function aThreadCanAddAReply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1,
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /**
     * Test whether a thread is associated with a channel
     * @test
     */
    public function aThreadBelongsToAChannel()
    {
        $this->assertInstanceOf(Channel::class, $this->thread->channel);
    }

    /**
     * Test the path to a single thread
     * @test
     */
    public function aThreadCanMakeAStringPath()
    {
        $this->assertEquals("/threads/{$this->thread->channel->slug}/{$this->thread->id}", $this->thread->path());
    }
}
