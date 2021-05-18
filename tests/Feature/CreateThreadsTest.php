<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guests_may_not_create_threads()
    {
        $this->get(route('threads.create'))->assertRedirect(route('login'));

        $this->assertGuest();

        $this->post('/threads')->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_create_new_threads()
    {
        $this->signIn();
        $thread = make(Thread::class);

        $this->post(route('threads.store', $thread->toArray()));

        $this->assertDatabaseCount('threads', 1);
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        create(Channel::class, [], 2);

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function authorized_users_can_delete_threads()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $this->json('DELETE', route('threads.delete', [$thread->channel, $thread]))
            ->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    function unauthorized_users_may_not_delete_threads()
    {
        $thread = create(Thread::class);

        $this->assertGuest();

        $this->delete(route('threads.delete', [$thread->channel, $thread]))
            ->assertRedirect('/login');
        $this->assertDatabaseHas('threads', ['id' => $thread->id]);

        $this->signIn();
        $this->delete(route('threads.delete', [$thread->channel, $thread]))
            ->assertStatus(403);
    }

    protected function publishThread($overrides = [])
    {
        $this->signIn();
        $thread = make(Thread::class, $overrides);
        return $this->post(route('threads.store', $thread->toArray()));
    }
}
