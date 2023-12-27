<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Illuminate\Http\Request;

class checkUserToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $loginToken = $request->header('Authorization');
        $uuid = $request->header('uuid');
        $check = DB::table('employees')
                    ->where('loginToken', '=', $loginToken)
                    ->where('uuid', '=', $uuid)
                    ->get();
        if(count($check) > 0)
        {
            return $next($request)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods','GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }
        else
        {
            $responseArray['status'] = 0;
            $responseArray['content'] = '';
            $responseArray['mssg'] = "Token mismatch";
            return response($responseArray, 403);
        }
    }
}
