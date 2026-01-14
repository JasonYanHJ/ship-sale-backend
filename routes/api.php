<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\EmailRuleController;
use App\Http\Controllers\SalerController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// 受保护的路由
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('/user', [AuthController::class, 'user']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/logout-all', [AuthController::class, 'logoutAll']);
        Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
    });

    Route::prefix('/users')->group(function () {
        Route::post('/dispatchers', [UserController::class, 'allDispatchers'])->middleware('role:admin');
    });

    Route::prefix('/salers')->middleware('role:admin,dispatcher')->group(function () {
        Route::post('/', [SalerController::class, 'index']);
        Route::post('/store', [SalerController::class, 'store']);
        Route::post('/show/{saler}', [SalerController::class, 'show']);
        Route::post('/update/{saler}', [SalerController::class, 'update']);
        Route::post('/destroy/{saler}', [SalerController::class, 'destroy']);
        Route::post('/update-tag-auto-forward/{saler}', [SalerController::class, 'updateTagAutoForward']);
    });

    Route::prefix('/tags')->middleware('role:admin,dispatcher')->group(function () {
        Route::post('/', [TagController::class, 'index']);
        Route::post('/store', [TagController::class, 'store']);
        Route::post('/show/{tag}', [TagController::class, 'show']);
        Route::post('/update/{tag}', [TagController::class, 'update']);
        Route::post('/destroy/{tag}', [TagController::class, 'destroy']);
    });

    Route::prefix('/emails')->group(function () {
        Route::post('/', [EmailController::class, 'index'])->middleware('role:admin');
        Route::post('/by-dispatcher', [EmailController::class, 'indexByDispatcher'])->middleware('role:dispatcher');
        Route::post('/{email}/dispatch', [EmailController::class, 'dispatchEmail'])->middleware('role:admin');
    });

    Route::prefix('/email-rules')->middleware('role:admin')->group(function () {
        Route::post('/', [EmailRuleController::class, 'index']);
    });

    Route::prefix('/email-rules')->middleware('role:admin')->group(function () {
        Route::post('/', [EmailRuleController::class, 'index']);
    });
});

// TODO: 解决附件查看的权限保护
Route::prefix('/email-attachments')->group(function () {
    Route::get('/cids/{cid}', [AttachmentController::class, 'showByCid']);
    Route::post('/sync-tags/{attachment}', [AttachmentController::class, 'syncTags']);
    Route::get('/{attachment}', [AttachmentController::class, 'show']);
});

Route::prefix('/internal')->group(function () {
    Route::post('/salers', [SalerController::class, 'index']);
});
