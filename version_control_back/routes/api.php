<?php

use App\Http\Controllers\FileVersionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/upload', [FileVersionController::class, 'upload']);
Route::get('/versions/{projectId}/{fileName}', [FileVersionController::class, 'versions']);
Route::get('/project/{projectId}/files', [FileVersionController::class, 'projectFiles']);
