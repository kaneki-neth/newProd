<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\View\Composers\ProfileComposer;

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
        // $businessUnits = DB::table('org_user_bu as ubu')
        // ->join('org_business_units as bu', 'ubu.bu_id', '=', 'bu.bu_id')
        // ->where('ubu.user_id', auth()->user()->id)
        // ->where('ubu.enabled', 1)
        // ->orderBy('bu.bu_name', 'ASC')
        // ->get();
        // dd($businessUnits);

        $testVariable = "SHARING FROM APPSERVICE PROVIDER HERE";
        // dd($testVariable);
        // View::share(['testVariable' => $testVariable, 'businessUnits' => $businessUnits]);
        View::share(['testVariable' => $testVariable]);
    }
}
