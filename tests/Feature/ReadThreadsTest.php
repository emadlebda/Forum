<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    protected function setUp(): void
    {
        parent::setUp();
        $this->thread = create(Thread::class);
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $this->get(route('threads.index'))
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_a_single_thread()
    {
        $this->get(route('threads.show', [$this->thread->channel, $this->thread]))
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create(Channel::class);
        $threadInChannel = create(Thread::class, ['channel_id' => $channel->id]);
        $threadNotInChannel = create(Thread::class);

        $this->get(route('threads.by.channel', $channel))
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_username()
    {
        $this->signIn(create(User::class, ['name' => 'JohnDoe']));
        $threadByJohn = create(Thread::class, ['user_id' => auth()->id()]);
        $threadNotByJohn = create(Thread::class);

        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    /** @test */
    function a_user_can_filter_threads_by_popularity()
    {
        $threadWithNoReplies = $this->thread;
        $threadWithOneReplies = Thread::factory()->has(Reply::factory()->count(1))->create();
        $threadWithTwoReplies = Thread::factory()->has(Reply::factory()->count(2))->create();
        $threadWithThreeReplies = Thread::factory()->has(Reply::factory()->count(3))->create();

        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3, 2, 1, 0], array_column($response, 'replies_count'));
    }

    /** @test */
    function a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = create(Thread::class);
        create(Reply::class, ['thread_id' => $thread->id], 2);

        $response = $this->getJson(route('replies.index', [$thread->channel, $thread]))->json();

        $this->assertCount(2, $response['data']);
        $this->assertEquals(2, $response['total']);
    }

    /** @test */
    function a_user_can_filter_threads_by_those_that_are_unanswered()
    {
        $thread = create(Thread::class);
        create(Reply::class, ['thread_id' => $thread->id]);

        $response = $this->getJson('threads?unanswered=1')->json();
        $this->assertCount(1, $response);
    }
}
