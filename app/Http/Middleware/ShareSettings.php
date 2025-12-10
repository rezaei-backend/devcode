<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\View;

class ShareSettings
{
    public function handle(Request $request, Closure $next)
    {
        $settings = Setting::first();
        View::share('settings', $settings);

        return $next($request);
    }
}
