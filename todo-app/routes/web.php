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
Route::get('/edit/{id}', [App\Http\Controllers\TodoController::class, 'update']);
Route::get('/delete/{id}', [App\Http\Controllers\TodoController::class, 'destroy']);
