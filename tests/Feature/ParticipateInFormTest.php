<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInFormTest extends TestCase
{
    use DatabaseMigrations;


    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $channel = create(Channel::class);
        $thread = create(Thread::class);

        $this->assertGuest()
            ->post(route('replies.store', [$channel, $thread]), [])
            ->assertRedirect(route('login'));

    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();

        $thread = create(Thread::class);
        $reply = create(Reply::class);

        $this->post(route('replies.store', [$thread->channel, $thread]), $reply->toArray());
        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->signIn();

        $this->withExceptionHandling();
        $thread = create(Thread::class);
        $reply = make(Reply::class, ['body' => null]);

        $this->post(route('replies.store', [$thread->channel, $thread]), $reply->toArray())
            ->assertSessionHasErrors('body');
    }

    /** @test */
    function unauthorized_users_cannot_delete_replies()
    {
        $this->withExceptionHandling();

        $reply = create(Reply::class);

        $this->assertGuest();
        $this->delete(route('replies.delete', $reply))
            ->assertRedirect('login');

        $this->signIn()
            ->delete(route('replies.delete', $reply))
            ->assertStatus(403);
    }

    /** @test */
    function authorized_users_can_delete_replies()
    {
        $this->signIn();
        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $this->delete(route('replies.delete', $reply))->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    function unauthorized_users_cannot_update_replies()
    {
        $this->withExceptionHandling();

        $reply = create(Reply::class);

        $this->patch(route('replies.update', $reply))
            ->assertRedirect('login');

        $this->signIn()
            ->patch(route('replies.update', $reply))
            ->assertStatus(403);
    }

    /** @test */
    function authorized_users_can_update_replies()
    {
        $this->signIn();

        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $updatedReply = 'You been changed, fool.';
        $this->patch(route('replies.update', $reply), ['body' => $updatedReply]);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }
}
