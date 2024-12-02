<?php

namespace App\Policies;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SubscraptionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        //
        if($user->role == 'admin')
        {
            return true;
        }

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Subscription $subscription)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Subscription $subscription)
    {
        //
    }
    public function change_status(User $user, Subscription $subscription)
    {
        //
        if($user->role == 'admin')
        {
            return true;
        }

    }
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Subscription $subscription)
    {
        //
        if($user->role == 'admin')
        {
            return true;
        }

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Subscription $subscription)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Subscription $subscription)
    {
        //
    }
}