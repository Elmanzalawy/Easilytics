<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\MetricsController;
use App\Http\Middleware\EnsureWebsiteDomainMatches;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v1',
    'as' => 'api.v1.',
], function () {
    Route::post('send-metrics', [MetricsController::class, 'logMetrics'])
        ->middleware(EnsureWebsiteDomainMatches::class)
        ->name('sendMetrics');
});
