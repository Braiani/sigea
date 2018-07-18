<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Registro;

class RegistroRematriculaPolicy
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

    public function delete(User $user, Registro $registro)
    {
        return $registro->user->id === $user->id or $user->isCogea;
    }

    public function aceitar(User $user, Registro $registro)
    {
        return $user->isCoord or $user->isCogea;
    }

    public function recusar(User $user, Registro $registro)
    {
        return $user->isCoord or $user->isCogea;
    }

    public function desfazer(User $user, Registro $registro)
    {
        return $user->isCoord or $user->isCogea;
    }
}
