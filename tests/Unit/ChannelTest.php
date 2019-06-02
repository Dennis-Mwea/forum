<?php

namespace Tests\Unit;

use App\Thread;
use App\Channel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChannelTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test whether a channel consists of threads.
     *@test
     */
    public function aChannelConsistsOfThreads()
    {
        $channel = create(Channel::class);

        // $this->assertInstanceOf(Collection::class, $channel->threads);
        // Or
        $thread = create(Thread::class, ['channel_id' => $channel->id]);

        $this->assertTrue($channel->threads->contains($thread));
    }
}
