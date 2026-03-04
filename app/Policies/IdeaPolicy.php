<?php

namespace App\Policies;

use App\Models\Idea;
use App\Models\User;

class IdeaPolicy
{
    /**
     *   Determine whether the user can view any models.
     */
    public function workWith(User $user, Idea $idea): bool
    {
        return $idea->user->is($user); // Verifica se o usuário é o dono da ideia
    }

}
