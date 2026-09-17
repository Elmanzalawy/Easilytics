<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Dtos\SendMetricsDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LogMetricsRequest;
use App\Services\MetricsService;

class MetricsController extends Controller
{
    public function logMetrics(LogMetricsRequest $request, MetricsService $metricsService): void
    {
        $sendMetricsDto = SendMetricsDto::from([
            ...$request->validated(),
            'ip' => $request->ip(),
            'host' => $request->getHost(),
            'referrer' => $request->input('referrer') ?? $request->header('referrer'),
            'fingerprint' => $request->fingerprint(),
        ]);
        $metricsService->logMetrics($sendMetricsDto);
    }
}
