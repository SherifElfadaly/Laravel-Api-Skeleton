<?php

namespace App\Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application as App;
use Illuminate\Session\SessionManager as Session;

class SetSessions
{
    protected $app;
    protected $session;
    
    /**
     * Init new object.
     *
     * @param   App      $app
     * @param   Session  $session
     *
     * @return  void
     */
    public function __construct(App $app, Session $session)
    {
        $this->app = $app;
        $this->session = $session;
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
        $this->session->put('time-zone', $request->header('time-zone') ?: 0);

        $locale = $request->header('locale');
        switch ($locale) {
            case 'en':
                $this->app->setLocale('en');
                $this->session->put('locale', 'en');
                break;

            case 'ar':
                $this->app->setLocale('ar');
                $this->session->put('locale', 'ar');
                break;

            default:
                $this->app->setLocale('en');
                $this->session->put('locale', 'en');
                break;
        }
        return $next($request);
    }
}
