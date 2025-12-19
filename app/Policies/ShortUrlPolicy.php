<?php

namespace App\Policies;

use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ShortUrlPolicy
{
    /**
     * Determine whether the user can view any models.
     * Visibility rules for listing short URLs
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     * Per-record visibility
     */
    public function view(User $user, ShortUrl $shortUrl): bool
    {
        // SuperAdmin sees everything
        if ($user->role->name === 'super_admin') {
            return true;
        }

        // Admin sees URLs from own company
        if ($user->role->name === 'admin') {
            return $shortUrl->company_id === $user->company_id;
        }

        // Member sees only their own URLs
        if ($user->role->name === 'member') {
            return $shortUrl->user_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     * Who can create short URLs
     */
    public function create(User $user): bool
    {
        // SuperAdmin cannot create short URLs
        if ($user->role->name === 'super_admin') {
            return false;
        }

        // Admin & Member must belong to a company
        return $user->company_id !== null;
        // return in_array($user->role->name, ['admin', 'member']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ShortUrl $shortUrl): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ShortUrl $shortUrl): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ShortUrl $shortUrl): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ShortUrl $shortUrl): bool
    {
        //
    }
}
