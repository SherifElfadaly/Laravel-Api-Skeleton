<?php

namespace App\Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Session\SessionManager as Session;
use Illuminate\Auth\AuthManager as Auth;

class UpdateLocaleAndTimezone
{
    protected $session;
    protected $auth;
    
    /**
     * Init new object.
     *
     * @param   Session      $session
     * @param   Auth         $auth
     * @param   Errors       $errors
     *
     * @return  void
     */
    public function __construct(Session $session, Auth $auth)
    {
        $this->session = $session;
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $update = false;
        $user   = $this->auth->user();
        if ($user) {
            $locale   = $this->session->get('locale');
            $timezone = $this->session->get('time-zone');
            if ($locale && $locale !== 'all' && $locale !== $user->locale) {
                $user->locale = $locale;
                $update       = true;
            }
    
            if ($timezone && $timezone !== $user->timezone) {
                $user->timezone = $timezone;
                $update         = true;
            }
    
            if ($update) {
                $user->save();
            }
        }

        return $next($request);
    }
}
