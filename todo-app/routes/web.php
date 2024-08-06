<?php

use Illuminate\Support\Facades\Route;
use app\Http\Controllers\TodoController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/todo', [App\Http\Controllers\TodoController::class, 'index']);
Route::post('/add', [App\Http\Controllers\TodoController::class, 'create']);
Route::get('/show/{id}', [App\Http\Controllers\TodoController::class, 'showById']);
Route::patch('/edit/{id}', [App\Http\Controllers\TodoController::class, 'update']);
Route::delete('/delete/{id}', [App\Http\Controllers\TodoController::class, 'destroy']);
Route::patch('/markAsDone/{id}', [App\Http\Controllers\TodoController::class, 'markAsDone']);
Route::patch('/markAsTodo/{id}', [App\Http\Controllers\TodoController::class, 'markAsTodo']);
