<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Retro;

class RetroPolicy
{
    /**
     * Determine whether the user can view any retrospectives.
     */
    public function viewAny(User $user)
    {
        return in_array($user->role, ['admin', 'teacher']);
    }

    /**
     * Determine whether the user can view the retro.
     */
    public function view(User $user, Retro $retro)
    {
        // Si l'utilisateur est un admin, il peut voir tout
        if ($user->role === 'admin') {
            return true;
        }

        // Si l'utilisateur est un teacher, il peut voir les rétros qu'il a créées
        if ($user->role === 'teacher' && $user->id === $retro->creator_id) {
            return true;
        }

        // Si l'utilisateur est un student, il peut voir les rétros liées à sa promotion
        if ($user->role === 'student' && $user->promotion_id === $retro->promotion_id) {
            return true;
        }

        return false; // Autrement, il n'a pas accès
    }

    /**
     * Determine whether the user can create retrospectives.
     */
    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'teacher']);
    }
}
