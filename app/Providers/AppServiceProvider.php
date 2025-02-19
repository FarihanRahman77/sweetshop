<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use DB;
use App\Models\Party;
use App\Models\Setups\CompanySetting;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        config(['settings.mode' => '0']);

        View::composer('admin.master',  function($view){
            $sisterConcernId=Session::get('companySettings')[0]['id'];
            $companySettings = CompanySetting::find($sisterConcernId);
            
            $view->with('companySettings',$companySettings);
        });




        View::composer('admin.includes.sidebar',  function($view){

            $users = DB::table('users')
            ->where('deleted','=', 'No')
            ->where('status','=', 'Active')
            ->get();
            $view->with('users',$users);
            
        });



        View::composer('admin.setups.companySettings.company-settings',  function($view){
            $suppliers = ["There are suppliers"];
            $view->with('suppliers',$suppliers);
            
        });


        View::composer('auth.login',  function($view){
            $sisterConcerns=CompanySetting::where('deleted','=','No')->where('status','=','Active')->get();
            $view->with('sisterConcerns',$sisterConcerns);
            
        });



        
    }
}
