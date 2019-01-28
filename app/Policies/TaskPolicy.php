<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Task;

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
        return $user->isAdmin;
    }

    public function create(User $user, Task $task)
    {
        return $user->isCogea;
    }

    public function update(User $user, Task $task)
    {
        return $user->id == $task->user_to or $user->isCogea;
    }

    public function delete(User $user, Task $task)
    {
        return $user->isCogea;
    }
}
