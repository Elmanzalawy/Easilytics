<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Services\AnalyticsScriptService;
use Illuminate\Http\Response;

class AnalyticsScriptController extends Controller
{
    public function __invoke(Website $website, AnalyticsScriptService $scripts): Response
    {
        return response($scripts->generate($website), 200, [
            'Content-Type' => 'application/javascript; charset=utf-8',
            'Cache-Control' => 'public, max-age=3600',
            'Access-Control-Allow-Origin' => '*',
        ]);
    }
}
