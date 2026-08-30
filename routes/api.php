<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PublicApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| REST API Routes (Sanctum Ready)
|--------------------------------------------------------------------------
*/

// Public Endpoints
Route::prefix('v1')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::get('/courses', [PublicApiController::class, 'courses']);
    Route::get('/courses/{slug}', [PublicApiController::class, 'courseDetail']);
    Route::get('/batches', [PublicApiController::class, 'batches']);
    Route::post('/enquiries', [PublicApiController::class, 'submitEnquiry']);
    Route::get('/certificates/verify/{code}', [PublicApiController::class, 'verifyCertificate']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/auth/profile', [AuthController::class, 'profile']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/students', [PublicApiController::class, 'students']);
    });
});

Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/courses', [PublicApiController::class, 'courses']);
Route::get('/courses/{slug}', [PublicApiController::class, 'courseDetail']);
Route::get('/batches', [PublicApiController::class, 'batches']);
Route::post('/enquiries', [PublicApiController::class, 'submitEnquiry']);
Route::get('/certificates/verify/{code}', [PublicApiController::class, 'verifyCertificate']);
