<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForceLogoutNewAdmin
{
    public function handle(Request $request, Closure $next) {
        if (!Auth::check()) {
            return $next($request); }

        $user = Auth::user();

        if ($user->is_admin && $user->must_change_password) {

            if ($request->is('force-password-change')) {
                return $next($request); }

            if ($request->is('logout') || $request->is('logout/*')) {
                return $next($request); }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')
                ->with('error', 'You must change your password before further access.'); }

        return $next($request); }
        }