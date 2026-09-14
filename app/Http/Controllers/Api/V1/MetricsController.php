<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LogMetricsRequest;
use App\Services\MetricsService;

class MetricsController extends Controller
{
    public function logMetrics(LogMetricsRequest $request, MetricsService $metricsService)// : void
    {
        return $metricsService->logMetrics($request);
    }
}
