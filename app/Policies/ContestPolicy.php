<?php

namespace App\Policies;

use App\Models\Contest;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class ContestPolicy
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
    public function view(User $user, Contest $contest): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Contest $contest): bool
    {
        foreach ($user->characters as $userCharacter) { 
            foreach ($contest->characters as $contestCharacter) {
                if ($userCharacter->id === $contestCharacter->id) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Contest $contest): bool
    {
        return $user -> id == $contest -> user_id || $user -> admin;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Contest $contest): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Contest $contest): bool
    {
        //
    }
}
