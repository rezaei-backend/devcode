<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            abort(404);
        }

        // اختیاری: اگر فقط ادمین خاصی بخوای دسترسی بده
        // if (!Auth::user()->is_admin) {
        //     abort(403);
        // }

        return $next($request);
    }
}
