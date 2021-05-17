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
        $this->withoutExceptionHandling();
        $this->signIn();

        $thread = create(Thread::class);
        $reply = create(Reply::class);

        $this->post(route('replies.store', [$thread->channel, $thread]), $reply->toArray());

        $this->get(route('threads.show', [$thread->channel, $thread]))
            ->assertSee($reply->body);
    }
}
