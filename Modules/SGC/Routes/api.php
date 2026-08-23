<?php

use Illuminate\Support\Facades\Route;
use Modules\SGC\Http\Controllers\SGCController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('sgcs', SGCController::class)->names('sgc');
});
