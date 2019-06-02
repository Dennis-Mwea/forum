<?php

namespace Tests\Unit;

use App\User;
use App\Reply;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;
    
    /**
     * Test whether a reply has an owner
     * @test
     */
    public function itHasAnOwner()
    {
        $reply = make(Reply::class);

        $this->assertInstanceOf(User::class, $reply->user);
    }
}
