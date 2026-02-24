<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/container-info', function () {
        return response()->json([
            'message' => 'Response from container publisher',
            'container' => 'container-1',
            'timestamp' => now()->toIso8601String(),
        ]);
    });
});
