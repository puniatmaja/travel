<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class MyMiddleware
{
    public function handle($request, Closure $next)
	{
    	if (Session::get('status') != 'login') {
            return redirect('admin');
        }
        
	}
	

}