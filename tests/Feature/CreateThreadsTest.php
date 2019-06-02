<?php

namespace Tests\Feature;

use App\User;
use App\Thread;
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
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('/threads', []);
    }

    /**
     * Test whether unauthenticated users can see the create threads page
     * @test
     */
    public function unAuthenticatedUsersCannotSeeThreadsPage()
    {
        $this->withExceptionHandling()
            ->get('/threads/create')
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

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
