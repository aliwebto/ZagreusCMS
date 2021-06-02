<?php

namespace Modules\Analytics\Http\Middleware;

use Modules\Analytics\Entities\Analytic as AnalyticModel;
use Modules\Analytics\Entities\Rule;
use Illuminate\Http\Request;
use Closure;
use URL;
use Route;

class Analytic
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user()->id ?? session()->getId();

        $analyticRow = AnalyticModel::whereIp($request->ip())
            ->whereUrl(URL::current())
            ->whereDate('created_at', \Carbon\Carbon::today())
            ->orWhere('user', $user)
            ->whereUrl(URL::current())
            ->whereDate('created_at', \Carbon\Carbon::today())->first();

        if ($analyticRow) {
            $analyticRow->increment('views');
        } else {
            AnalyticModel::create([
                'user'=> $user,
                'url'=> URL::current(),
                'route'=> Route::currentRouteName(),
                'ip'=> $request->ip(),
                'meta'=> null
            ]);
        }
        
        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function terminate($request, $response)
    {
        // ...
    }
}
