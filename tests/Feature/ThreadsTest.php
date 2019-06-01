<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @test
     */
    public function aUserCanBrowseThreads()
    {
        $thread = factory(Thread::class)->create();

        $this->get('/threads')
            ->assertSee($thread->title)
            ->assertSee($thread->body);

        $this->get('/threads/' . $thread->id)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
