<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;

class CheckProxy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    protected function isLocalIp($ip): bool
    {
        return $ip === '127.0.0.1' || $ip === '::1' ||
               preg_match('/^(10\.|192\.168\.|172\.(1[6-9]|2\d|3[01])\.)/', $ip);
    }

    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        if ($this->isLocalIp($ip)) {
            return $next($request);
        }

        $response = Http::get("https://proxycheck.io/v2/{$ip}", [
            'vpn' => 1,
            'asn' => 1,
        ]);
        $data = $response->json();
        if ($data['status'] == "ok") {
            if ($data[$ip]['proxy'] != "yes") {
                return $next($request);
            }
        }
        session([
            'ip_address' => $ip,
            'user_agent' => request()->header('User-Agent')
        ]);
        return redirect(route("proxy"));        
    }
}
