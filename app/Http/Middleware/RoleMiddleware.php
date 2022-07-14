<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $mulRoles = explode('|', $role);
        $matched = 0;
        foreach ($mulRoles as $mulRole) {
            if ($mulRole == \Auth::user()->role) {
                $matched = 1;
            }
        }

        if ($matched == 0) {
            session()->flash('error', 'You did not have permission to access this route.');
            return redirect()->route('home');
        }
        // if(sizeof($mulRoles)>1){
        //     $any_role_macthed = 0;
        //     foreach($mulRoles as $new_role) {
        //         if($request->user()->role==$new_role) {
        //              $any_role_macthed = 1;
        //         }
        //     }
        //     if($any_role_macthed == 0){
        //         abort(404);
        //     }
        // }else{
        //     if(!$request->user()->role==$new_role) {

        //          abort(404);

        //     }
        // }

        // if($permission !== null && !$request->user()->can($permission)) {

        //       abort(404);
        // }
        return $next($request);
    }
}