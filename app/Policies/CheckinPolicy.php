<?php

namespace App\Policies;

use App\User;
use App\Models\Checkin;
use Illuminate\Auth\Access\HandlesAuthorization;

class CheckinPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any checkins.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        if ($user->isManagerCompany()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the checkin.
     *
     * @param  \App\User  $user
     * @param  \App\Checkin  $checkin
     * @return mixed
     */
    public function view(User $user, Checkin $checkin)
    {
        if ($user->isManagerCompany()) {
            return true;
        }
    }

    /**
     * Determine whether the user can create checkins.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->isManagerCompany()) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the checkin.
     *
     * @param  \App\User  $user
     * @param  \App\Checkin  $checkin
     * @return mixed
     */
    public function update(User $user, Checkin $checkin)
    {
        if ($user->isManagerCompany()) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the checkin.
     *
     * @param  \App\User  $user
     * @param  \App\Checkin  $checkin
     * @return mixed
     */
    public function delete(User $user, Checkin $checkin)
    {
        //
    }

    /**
     * Determine whether the user can restore the checkin.
     *
     * @param  \App\User  $user
     * @param  \App\Checkin  $checkin
     * @return mixed
     */
    public function restore(User $user, Checkin $checkin)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the checkin.
     *
     * @param  \App\User  $user
     * @param  \App\Checkin  $checkin
     * @return mixed
     */
    public function forceDelete(User $user, Checkin $checkin)
    {
        //
    }
}
