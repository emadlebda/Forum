<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view any replies.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the reply.
     *
     * @param User $user
     * @param Reply $reply
     * @return bool
     */
    public function view(User $user, Reply $reply)
    {
        //
    }

    /**
     * Determine whether the user can create replies.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the reply.
     *
     * @param User $user
     * @param Reply $reply
     * @return bool
     */
    public function update(User $user, Reply $reply)
    {
        return $reply->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the reply.
     *
     * @param User $user
     * @param Reply $reply
     * @return bool
     */
    public function delete(User $user, Reply $reply)
    {
        return $reply->user_id == $user->id;
    }

    /**
     * Determine whether the user can restore the reply.
     *
     * @param User $user
     * @param Reply $reply
     * @return bool
     */
    public function restore(User $user, Reply $reply)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the reply.
     *
     * @param User $user
     * @param Reply $reply
     * @return bool
     */
    public function forceDelete(User $user, Reply $reply)
    {
        //
    }
}
