<?php

use App\Http\Controllers\NoteBookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/v1/notebook', [NoteBookController::class, 'index']);

Route::get('/v1/notebook/{id}', [NoteBookController::class, 'getOne'])->where('id', '[0-9]+');

Route::post('/v1/notebook', [NoteBookController::class, 'add']);

Route::post('/v1/notebook/{id}', [NoteBookController::class, 'add'])->where('id', '[0-9]+');

Route::delete('/v1/notebook/{id}', [NoteBookController::class, 'delete'])->where('id', '[0-9]+');
