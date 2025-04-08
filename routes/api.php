<?php

use App\Http\Controllers\SalerController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/salers')->group(function () {
    Route::post('/', [SalerController::class, 'index']);
    Route::post('/store', [SalerController::class, 'store']);
    Route::post('/show/{saler}', [SalerController::class, 'show']);
    Route::post('/update/{saler}', [SalerController::class, 'update']);
    Route::post('/destroy/{saler}', [SalerController::class, 'destroy']);
});

Route::prefix('/tags')->group(function () {
    Route::post('/', [TagController::class, 'index']);
    Route::post('/store', [TagController::class, 'store']);
    Route::post('/show/{tag}', [TagController::class, 'show']);
    Route::post('/update/{tag}', [TagController::class, 'update']);
    Route::post('/destroy/{tag}', [TagController::class, 'destroy']);
});
