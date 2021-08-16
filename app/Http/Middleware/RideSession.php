<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RideSession
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
        $dokuwiki_session_name = config('app.dokuwiki_session_name');
        $dokuwiki_session_rel = config('app.dokuwiki_session_rel');

        if ($dokuwiki_session_name) {
            session_name($dokuwiki_session_name);
            if(!isset($_SESSION)) {
                session_start();
            }
            $dokuwiki_cookie = 'DW'.md5($dokuwiki_session_rel.$_SERVER['SERVER_PORT']);
            if (array_key_exists($dokuwiki_cookie, $_SESSION)) {
                $account = [
                    'id' => $_SESSION[$dokuwiki_cookie]['auth']['user'],
                    'name' => $_SESSION[$dokuwiki_cookie]['auth']['info']['name'],
                    'privs' => $_SESSION[$dokuwiki_cookie]['auth']['info']['grps'],
                ];
                $request->attributes->add(['account' => $account]);
            } else {
                return redirect(config('app.site_url'));
            }
        } else {
            return redirect(config('app.site_url'));
        }

        return $next($request);
    }
}
