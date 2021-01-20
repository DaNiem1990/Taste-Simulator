<?php

namespace App\Http\Middleware;

use App\Http\Controllers\API\NotAuthorizedController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()->isadmin) {
            return redirect()->route('notauthorized');
        }

        return $next($request);
    }
}
