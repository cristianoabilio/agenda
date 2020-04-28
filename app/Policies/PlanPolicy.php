<?php

namespace App\Policies;

use App\User;
use App\Plan;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlanPolicy
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

    /**
     * Determine whether the user can view the plan.
     *
     * @param  \App\User  $user
     * @param  \App\Plan  $plan
     * @return mixed
     */
    public function view(User $user, Plan $plan)
    {
        if ($user->isManagerCompany()) {
            return true;
        }
    }

    /**
     * Determine whether the user can create plans.
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
     * Determine whether the user can update the plan.
     *
     * @param  \App\User  $user
     * @param  \App\Plan  $plan
     * @return mixed
     */
    public function update(User $user, Plan $plan)
    {
        if ($user->isManagerCompany()) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the plan.
     *
     * @param  \App\User  $user
     * @param  \App\Plan  $plan
     * @return mixed
     */
    public function delete(User $user, Plan $plan)
    {
        if ($user->isManagerCompany()) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the plan.
     *
     * @param  \App\User  $user
     * @param  \App\Plan  $plan
     * @return mixed
     */
    public function restore(User $user, Plan $plan)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the plan.
     *
     * @param  \App\User  $user
     * @param  \App\Plan  $plan
     * @return mixed
     */
    public function forceDelete(User $user, Plan $plan)
    {
        //
    }
}
