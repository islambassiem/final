<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class Head
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $heads = User::distinct('head')->pluck('head')->toArray();
    if(! in_array(auth()->user()->id, $heads)){
      return redirect()->route('not-allowed');
    }
    return $next($request);
  }
}
