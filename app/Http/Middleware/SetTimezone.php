<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetTimezone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $response = $next($request);
        $timezone = $request->header('X-Header-Timezone');

        if (! in_array($timezone, timezone_identifiers_list())) {
            $request->headers->set('X-Header-Timezone', 'America/Caracas');
        }

        // return $response;
        return $next($request)
            ->header(
                'X-Header-Timezone',
                $request->header('X-Header-Timezone')
            );
    }
}
