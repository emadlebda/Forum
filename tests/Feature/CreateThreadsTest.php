<?php

namespace Tests\Feature;

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
        $this->assertGuest();

        $thread = make(Thread::class);

        $this->post(route('threads.store'), $thread->toArray());
    }

    /** @test */
    public function an_authenticated_user_can_create_new_threads()
    {
        $this->be(create(User::class));
        $thread = make(Thread::class);

        $this->post(route('threads.store', $thread->toArray()));

        $this->assertDatabaseCount('threads', 1);
//        $this->get(route('threads.show', $thread))
//            ->assertSee($thread->title)
//            ->assertSee($thread->body);
    }
}
