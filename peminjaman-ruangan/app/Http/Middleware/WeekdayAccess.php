<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class WeekdayAccess
{
    public function handle(Request $request, Closure $next)
    {
        $dayOfWeek = Carbon::now()->dayOfWeek; 

        // Jika hari Sabtu (6) atau Minggu (0), tolak akses
        if ($dayOfWeek === 0 || $dayOfWeek === 6) {
            return response()->view('errors.weekend', [], 403);
        }

        // Lanjutkan request jika weekday
        return $next($request);
    }
}
