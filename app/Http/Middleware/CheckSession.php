<?php

namespace App\Http\Middleware;

use Closure;

class CheckSession
{

    public function handle($request, Closure $next)
    {   
        session([
            'SESS_RETURN' => $request->path()
        ]);
        if (!session()->has('user')) {

            //return redirect('seguridad.login');
            return redirect()->route('seguridad.login');
        }
    
        return $next($request);
    }
}
