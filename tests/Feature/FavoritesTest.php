<?php

namespace Tests\Feature;

use App\Reply;
use Tests\TestCase;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    protected $reply;

    /**
     * FavoritesTest constructor.
     * @param $reply
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->reply = create(Reply::class);
    }


    /**
     * Test whether unauthenticated users cannot favorite a reply.
     * @test
     */
    public function unauthenticatedUsersMayNotFavoriteReplies()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->withExceptionHandling()
            ->post('/replies/' . $this->reply->id . '/favorites', [])
            ->assertRedirect('/login');
    }

    /**
     * Test whether authenticated users can favorite replies
     * @test
     */
    public function authenticatedUsersMayFavoriteReplies()
    {
        $this->signIn();

        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post('/replies/' . $this->reply->id . '/favorites');

        $this->assertCount(1, $this->reply->favorites);
    }

    /**
     * Test whether authenticated users can favorite replies only once
     * @test
     */
    public function authenticatedUsersMayFavoriteRepliesOnlyOnce()
    {
        $this->signIn();

        try {
            $this->withoutMiddleware(VerifyCsrfToken::class)
                ->post('/replies/' . $this->reply->id . '/favorites');
            $this->withoutMiddleware(VerifyCsrfToken::class)
                ->post('/replies/' . $this->reply->id . '/favorites');
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert the same record twice.');
        }

        $this->assertCount(1, $this->reply->favorites);
    }
}
