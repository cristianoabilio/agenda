<?php

namespace App\Policies;

use App\User;
use App\Models\Classes;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassesPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any classes.
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
     * Determine whether the user can view the classes.
     *
     * @param  \App\User  $user
     * @param  \App\Classes  $classes
     * @return mixed
     */
    public function view(User $user, Classes $classes)
    {
        if ($user->isManagerCompany()) {
            return true;
        }

    }

    /**
     * Determine whether the user can create classes.
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
     * Determine whether the user can update the classes.
     *
     * @param  \App\User  $user
     * @param  \App\Classes  $classes
     * @return mixed
     */
    public function update(User $user, Classes $classes)
    {
        if ($user->isManagerCompany()) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the classes.
     *
     * @param  \App\User  $user
     * @param  \App\Classes  $classes
     * @return mixed
     */
    public function delete(User $user, Classes $classes)
    {
        if ($user->isManagerCompany()) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the classes.
     *
     * @param  \App\User  $user
     * @param  \App\Classes  $classes
     * @return mixed
     */
    public function restore(User $user, Classes $classes)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the classes.
     *
     * @param  \App\User  $user
     * @param  \App\Classes  $classes
     * @return mixed
     */
    public function forceDelete(User $user, Classes $classes)
    {
        //
    }
}
