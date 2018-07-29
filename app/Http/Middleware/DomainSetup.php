<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DomainSetup {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        $subdomain = $request->getHost();
        $account_data = Company::where('domain', $subdomain)->where('status', 'enable')->first();
        if (!$account_data) {
            if ($subdomain == 'localhost' || $subdomain == 'staging.cpos360.com') {
                return $next($request);
            }
            return abort(404);
        }

        Config::set('database.connections.mongodb.database', $account_data->database);
        DB::purge('mongodb');
        DB::reconnect('mongodb');        
        return $next($request);
    }

}
