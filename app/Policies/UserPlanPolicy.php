<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPlanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any company modalities.
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
     * Determine whether the user can view the company modality.
     *
     * @param  \App\User  $user
     * @param  \App\CompanyModality  $companyModality
     * @return mixed
     */
    public function view(User $user, CompanyModality $companyModality)
    {
        if ($user->isManagerCompany()) {
            return true;
        }
    }

    /**
     * Determine whether the user can create company modalities.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the company modality.
     *
     * @param  \App\User  $user
     * @param  \App\CompanyModality  $companyModality
     * @return mixed
     */
    public function update(User $user, CompanyModality $companyModality)
    {
        //
    }

    /**
     * Determine whether the user can delete the company modality.
     *
     * @param  \App\User  $user
     * @param  \App\CompanyModality  $companyModality
     * @return mixed
     */
    public function delete(User $user, CompanyModality $companyModality)
    {
        //
    }

    /**
     * Determine whether the user can restore the company modality.
     *
     * @param  \App\User  $user
     * @param  \App\CompanyModality  $companyModality
     * @return mixed
     */
    public function restore(User $user, CompanyModality $companyModality)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the company modality.
     *
     * @param  \App\User  $user
     * @param  \App\CompanyModality  $companyModality
     * @return mixed
     */
    public function forceDelete(User $user, CompanyModality $companyModality)
    {
        //
    }    
}
