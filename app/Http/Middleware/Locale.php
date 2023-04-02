<?php

namespace App\Http\Middleware;

use Closure;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $segment = $request->segment(1);
        if ($request->method() === 'GET') {

            if (!in_array($segment, config('app.locales'))) {
                $segments = $request->segments();
                $fallback = config('app.fallback_locale');
                $segments = array_prepend($segments, $fallback);

                return redirect()->to(implode('/', $segments));
            }

            app()->setLocale($segment);
        }

        return $next($request);
    }
}
