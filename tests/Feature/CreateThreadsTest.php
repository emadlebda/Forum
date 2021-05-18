<?php

namespace Tests\Feature;

use App\Models\Channel;
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
        $this->publishThread(['channel_id' => null])->assertSessionHasErrors('channel_id');
        $channel = create(Channel::class);
        $channel2 = create(Channel::class);
        $this->publishThread(['channel_id' => 999])->assertSessionHasErrors('channel_id');
    }

    protected function publishThread($overrides = [])
    {
        $this->signIn();
        $thread = make(Thread::class, $overrides);
        return $this->post(route('threads.store', $thread->toArray()));
    }
}
