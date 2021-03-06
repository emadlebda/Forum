<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_user_has_a_profile()
    {
        $user = create(User::class);

        $this->get(route('profile', $user))
            ->assertSee($user->name);
    }

    /** @test */
    function profiles_display_all_threads_created_by_the_associated_user()
    {
        $this->signIn($user=create(User::class));

        $thread = create(Thread::class, ['user_id' => $user->id]);

        $this->get(route('profile', $user))
            ->assertSee($thread->title);

    }
}
