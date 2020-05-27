<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Log;

class SocialMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $services = explode(',', env('SOCIAL_LIST'));
        $enabledServices = [];
        foreach ($services as $service) {
            if (config('services.' . $service)) {
                Log::info(config('services.' . $service));
                $enabledServices[] = $service;
            }
        }

        if (!in_array(strtolower($request->service), $enabledServices)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid social service'
                ], 403);
            }

            return redirect(env('CLIENT_BASE_URL') . '/auth/login');
        }

        return $next($request);
    }
}
