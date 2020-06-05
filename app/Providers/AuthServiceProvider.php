<?php

namespace App\Providers;

use App\Models\Checkin;
use App\Models\Classes;
use App\Models\Company;
use App\Models\CompanyModality;
use App\Models\Plan;
use App\Models\UserPlan;
use App\User;

use App\Policies\CheckinPolicy;
use App\Policies\ClassesPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\CompanyModalityPolicy;
use App\Policies\PlanPolicy;
use App\Policies\UserPlanPolicy;
use App\Policies\UserPolicy;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [        
        Checkin::class => CheckinPolicy::class,    
        Classes::class => ClassesPolicy::class,
        Company::class => CompanyPolicy::class,
        CompanyModality::class => CompanyModalityPolicy::class,        
        Plan::class => PlanPolicy::class,      
        UserPlan::class => UserPlanPolicy::class,      
        User::class => UserPolicy::class,      
          
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

    }
}
