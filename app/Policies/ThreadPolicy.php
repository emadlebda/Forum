<?php

namespace App\Policies;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view any threads.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the thread.
     *
     * @param User $user
     * @param Thread $thread
     * @return bool
     */
    public function view(User $user, Thread $thread)
    {
        //
    }

    /**
     * Determine whether the user can create threads.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the thread.
     *
     * @param User $user
     * @param Thread $thread
     * @return bool
     */
    public function update(User $user, Thread $thread)
    {
        return $thread->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the thread.
     *
     * @param User $user
     * @param Thread $thread
     * @return bool
     */
    public function delete(User $user, Thread $thread)
    {
        return $thread->user_id == $user->id;
    }

    /**
     * Determine whether the user can restore the thread.
     *
     * @param User $user
     * @param Thread $thread
     * @return bool
     */
    public function restore(User $user, Thread $thread)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the thread.
     *
     * @param User $user
     * @param Thread $thread
     * @return bool
     */
    public function forceDelete(User $user, Thread $thread)
    {
        //
    }
}
