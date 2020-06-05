<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    { 
        if ($user->isSuperAdmin()) {
            return true;
        }        
    }

    /**
     * Determine whether the user can view any plans.
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
}
