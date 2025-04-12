<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class GroupsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        $userSchools = $user->schoolRoles;  

        foreach ($userSchools as $userSchool) {
            // Check if the user has the 'admin' or 'teacher' role in any of their schools
            if ($userSchool->role === 'admin' || $userSchool->role === 'teacher') {
                return $next($request);
            }
        }

        abort(403, 'Accès refusé : vous devez être administrateur.');
    }
}
