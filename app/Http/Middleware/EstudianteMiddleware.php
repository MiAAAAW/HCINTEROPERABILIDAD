<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
//use Auth;
class EstudianteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!empty(Auth::check()))
        {
          if(Auth::user()->user_type == 3)
          {
             return $next($request);
          }   
            else 
          {
             Auth::logout();
             return redirect(url('/'));
          }
            
        }
        else
        {
          Auth::logout(); 
          // return $next($request);  
          return redirect('/');
        }
    }
}
