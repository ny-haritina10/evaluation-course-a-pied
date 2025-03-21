<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AdminLoginController;
use App\Http\Controllers\Api\EquipeLoginController;
use App\Http\Controllers\Api\DatabaseResetController;
use App\Http\Controllers\Api\CourseEtapeController;
use App\Http\Controllers\Api\CoureurEtapeController;
use App\Http\Controllers\Api\CoureurController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public routes
Route::post('/admin/login', [AdminLoginController::class, 'login']);
Route::post('/equipe/login', [EquipeLoginController::class, 'login']);

// Admin protected routes
Route::prefix('admin')->middleware(['auth:sanctum', 'admin.role'])->group(function () {
    Route::delete('/reset-database', [DatabaseResetController::class, 'reset']);
});

// Equipe protected routes
Route::prefix('equipe')->middleware(['auth:sanctum', 'equipe.role'])->group(function () {
    Route::get('/courses/etapes', [CourseEtapeController::class, 'index']);
    Route::post('/coureurs/assign', [CoureurEtapeController::class, 'assignCoureurToEtape']);
    Route::get('/coureurs', [CoureurController::class, 'getEquipeCoureurs']);
});