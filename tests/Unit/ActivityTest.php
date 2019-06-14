<?php

namespace Tests\Unit;

use App\Reply;
use App\Thread;
use App\Activity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * Test whether an activity is recorded when a user is created
     * @test
     */
    public function recordsActivityWhenAThreadIsCreated()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread'
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    public function recordsActivityWhenAReplyIsCreated()
    {
        $this->signIn();

        $reply = create(Reply::class);
        
        $this->assertEquals(2, Activity::count());
    }
}
