<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::check()) {
            $expire = now()->addMinutes(2); /* keep online for 2 min */
            Cache::put('user-is-online-' .Auth::user()->id,true,$expire);

            /* last seen */
            User::where('id',Auth::user()->id)->update(['last_seen' => now()]);

        }
        return $next($request);
    }
}
