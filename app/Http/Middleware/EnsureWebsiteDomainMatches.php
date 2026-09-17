<?php

namespace App\Http\Middleware;

use App\Models\Website;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureWebsiteDomainMatches
{
    public function handle(Request $request, Closure $next): Response
    {
        $website = Website::where('uuid', $request->input('website_uuid'))->first();

        abort_unless($website && $request->host() === $website->domain, 403);

        return $next($request);
    }
}
