<?php

namespace App\Providers;
use App\Models\Classes;
use App\Models\Company;
use App\Models\CompanyModality;

use App\Policies\ClassesPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\CompanyModalityPolicy;

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
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Classes::class => ClassesPolicy::class,
        Company::class => CompanyPolicy::class,
        CompanyModality::class => CompanyModalityPolicy::class,        
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
