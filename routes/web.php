<?php

use App\Http\Controllers\AnalyticsScriptController;
use Illuminate\Support\Facades\Route;

Route::get('/analytics/{website:uuid}.js', AnalyticsScriptController::class)
    ->name('analytics.script');

Route::get('/', function () {
    return view('welcome');
});
