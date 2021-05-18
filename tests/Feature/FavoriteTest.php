<?php

namespace Tests\Feature;

use App\Models\Reply;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guests_can_not_favorite_anything()
    {
        $this->withExceptionHandling()
            ->assertGuest()
            ->post(route('reply.favorite', create(Reply::class)))
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();

        $reply = create(Reply::class);

        $this->post(route('reply.favorite', $reply));

        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    function an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->signIn();

        $reply = create(Reply::class);

        try {
            $this->post(route('reply.favorite', $reply));
            $this->post(route('reply.favorite', $reply));
        } catch (\Exception $exception) {
            $this->fail('Did not expect to insert the same record set twice.');
        }

        $this->assertCount(1, $reply->favorites);
    }
}
