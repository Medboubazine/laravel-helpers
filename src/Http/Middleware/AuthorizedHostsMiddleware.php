<?php

namespace Medboubazine\LaravelHelpers\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Medboubazine\LaravelHelpers\Classes\Traits\Hosts;
use Medboubazine\LaravelHelpers\Classes\Variables;

class AuthorizedHostsMiddleware
{
    use Hosts;
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $status = $this->verifyHosts();

        if (!$status) {
            $this->setVerifiedHost();
        }

        return $next($request);
    }
}
