<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    if(auth()->check()){
      if(!in_array(auth()->user()->id, ['15', '71', '100', '206'])){
        return redirect()->route('not-allowed');
      }
    }
    return $next($request);
  }
}
