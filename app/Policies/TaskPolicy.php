<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Task;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before($user, $ability)
    {
        if ($user->isAdmin) {
            return true;
        }
    }

    public function create(User $user, Task $task)
    {
        return $user->isCogea;
    }

    public function see(User $user, Task $task)
    {
        return $user->id === $task->user_to or $user->isCogea;
    }

    public function delete(User $user, Task $task)
    {
        return $user->isCogea;
    }
}
