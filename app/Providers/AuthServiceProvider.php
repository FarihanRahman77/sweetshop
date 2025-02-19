<?php

namespace App\Providers;
use View;

use DB;
use App\Models\Team;
use App\Policies\TeamPolicy;
use App\Models\Setups\CompanySetting;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        View::composer('auth.login',  function($view){

            $companySettings = CompanySetting::first();
            Session::forget('companySettings');
            Session::push('companySettings', $companySettings); 

            $view->with('companySettings',$companySettings);
            
        });
        $this->registerPolicies();
    }
}
