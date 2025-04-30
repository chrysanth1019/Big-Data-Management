<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckIP
{
    protected function isLocalIp($ip): bool
    {
        return $ip === '127.0.0.1' || $ip === '::1' ||
               preg_match('/^(10\.|192\.168\.|172\.(1[6-9]|2\d|3[01])\.)/', $ip);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $ip = $request->ip();

        if ($this->isLocalIp($ip)) {
            return $next($request);
        }

        if ($user->allowed_ips == null || $user->allowed_ips == "") {
            return $next($request);
        }
        if (in_array($ip, $user->allowed_ips)) {
            return $next($request);    
        }
        session([
            'ip_address' => $ip,
        ]);
        return redirect(route("restricted"));
    }
}
