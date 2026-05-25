<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserLastActiveAt
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if($user){
            $user->forceFill([ // I didn't add it to User model fillable so I user forceFill method
                'last_active_at' => Carbon::now(), // Carbon is a php package for the date time
            ])
            ->save();
        }
        return $next($request);
    }
}
