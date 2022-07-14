<?php

namespace App\Providers;

use Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        view()->composer('*', function ($view) {
            if (Auth::check()) {
                if (\Auth::user()) {
                    $pincode1 = \App\Address::where('user_id', '=', \Auth::user()->id)
                        ->where('set_as_a_default', '=', 'Yes')
                        ->where('set_as_a_current', '=', 'Yes')
                        ->first();
                }

                $pincode_value = request()->cookie('zip_code');
                $pin_code = json_decode($pincode_value);
                if ($pin_code) {
                } else {
                    if ($pincode1) {
                        $pin_code = $pincode1->PIN;
                    } elseif ($pin_code) {

                    } else {
                        $pin_code = '110001';

                    }
                }

                $pincode = \App\Pincode::where('pincode', $pin_code)->first();
                if ($pincode) {
                    $office_state = \App\OfficeState::where('State_Code', $pincode->state_id)->first();
                    if ($office_state) {
                        view()->share('Global_Office_Code', $office_state->Office_Code);
                    } else {
                        view()->share('Global_Office_Code', 1);
                    }
                } else {
                    $office_state = 1;
                    view()->share('Global_Office_Code', $office_state);
                }
            } else {
                $pincode_value = request()->cookie('zip_code');
                $pin_code = json_decode($pincode_value);
                if ($pin_code) {
                } else {
                    $pin_code = '110001';
                }

                $pincode = \App\Pincode::where('pincode', $pin_code)->first();
                if ($pincode) {
                    $office_state = \App\OfficeState::where('State_Code', $pincode->state_id)->first();
                    if ($office_state) {
                        view()->share('Global_Office_Code', $office_state->Office_Code);
                    } else {
                        view()->share('Global_Office_Code', 1);
                    }

                } else {
                    $office_state = 1;
                    view()->share('Global_Office_Code', $office_state);

                }
            }
        });

        Schema::defaultStringLength(191);
    }

}