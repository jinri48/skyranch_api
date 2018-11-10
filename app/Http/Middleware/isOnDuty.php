<?php

namespace App\Http\Middleware;

use Closure;

use App\Clarion;
use App\UserSite;
use App\CCEOnDuty;

class isOnDuty
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //check token
        $user = UserSite::findByToken($request->header('token'));
        if(is_null($user) || $request->header('token')==null){
            return response()->json([
                'success'           => false,
                'status'            => 401,
                'message'           => 'Unauthenticated Request'
            ]);
        }

        //check if on duty
        $c      = new Clarion;      
        $cce    = new CCEOnDuty;    
         

        if( is_null($cce->isOnDuty(trim($user->NUMBER), $c->today() )) ){
            return response()->json([
                'success'           => false,
                'status'            => 401,
                'message'           => 'Not on Duty!'
            ]);
        }

        return $next($request);
    }
}
