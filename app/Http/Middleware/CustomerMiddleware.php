<?php
/**
 * Created by PhpStorm.
 * User: yugan
 * Date: 1/19/2019
 * Time: 5:07 PM
 */

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;

class CustomerMiddleware
{
	public function handle($request, Closure $next)
	{
		if(Auth::check()){
			if (Auth::user()->role == 0) {
				return $next($request);
			}

			return response()->view('error.404', [], 404);
		}
		else{
			return redirect('/login');
		}
	}
}