<?php

namespace App\Http\Middleware;

use App\PerfilAcesso;
use Closure;
use Symfony\Component\HttpFoundation\Response;

class AuthSessionRegulador
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
        if ($request->session()->exists('userData') === false) {
            return redirect()->route('login');
        }

        $perfil = $request->session()->get('userData')['perfil'];

        if ($perfil != PerfilAcesso::MEDICO_REGULADOR) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return $next($request);
    }
}
