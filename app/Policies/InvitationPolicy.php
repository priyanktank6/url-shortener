<?php

namespace App\Policies;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InvitationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Invitation $invitation): bool
    {
        //
    }

    /**
     * Determine whether the user can create invitations.
     */
    public function create(User $user, string $role): bool
    {
        // SuperAdmin can invite Admin only (new company)
        if ($user->role->name === 'super_admin') {
            return $role === 'admin';
        }

        // Admin can invite Admin or Member (own company)
        if ($user->role->name === 'admin') {
            return in_array($role, ['admin', 'member']);
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Invitation $invitation): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Invitation $invitation): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Invitation $invitation): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Invitation $invitation): bool
    {
        //
    }
}
