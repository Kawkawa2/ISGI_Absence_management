<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\role;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/auth/login');
        }

        $user = Auth::user();
        $allowedRoleIds = Role::pluck('id')->toArray();

        if (!in_array($user->role_id, $allowedRoleIds)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
