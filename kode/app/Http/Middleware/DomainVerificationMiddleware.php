<?php

namespace App\Http\Middleware;

use App\Enums\StatusEnum;
use App\Models\Core\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class DomainVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
}
