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
        $locale = $request->header('locale', 'en');
        $timeZone = $request->header('time-zone', 0);

        $this->session->put('time-zone', $timeZone);
        $this->session->put('locale', $locale);
        $this->app->setLocale($locale);

        return $next($request);
    }
}
