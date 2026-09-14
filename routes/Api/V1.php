<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\MetricsController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v1',
    'as' => 'api.v1.',
], function () {
    Route::get('send-metrics', [MetricsController::class, 'logMetrics'])->name('sendMetrics');
});
