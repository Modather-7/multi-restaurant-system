<?php

namespace App\Http\Middleware;

use App\Helpers\CurrentBranchId;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBranchSelected
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $restaurant = $request->route('restaurant');

        $branchId = CurrentBranchId::getBranchId();

        if (! $branchId) {
            return redirect()->route('restaurant.branches', $restaurant);
        }

        $exists = $restaurant->branches()
            ->where('id', $branchId)
            ->where('status', 'active')
            ->exists();

        if (! $exists) {
            return redirect()->route('restaurant.branches', $restaurant);
        }



        return $next($request);
    }
}
