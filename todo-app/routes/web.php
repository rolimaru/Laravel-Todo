<?php

use Illuminate\Support\Facades\Route;
use app\Http\Controllers\TodoController;
use app\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});
Route::get('/todo', [App\Http\Controllers\TodoController::class, 'index'])->name('todo');
Route::post('/add', [App\Http\Controllers\TodoController::class, 'create']);
Route::get('/show/{id}', [App\Http\Controllers\TodoController::class, 'showById']);
Route::patch('/edit/{id}', [App\Http\Controllers\TodoController::class, 'update']);
Route::delete('/delete/{id}', [App\Http\Controllers\TodoController::class, 'destroy']);
Route::patch('/markAsDone/{id}', [App\Http\Controllers\TodoController::class, 'markAsDone']);
Route::patch('/markAsTodo/{id}', [App\Http\Controllers\TodoController::class, 'markAsTodo']);


//for Login
Route::post('/registerSubmit', [App\Http\Controllers\AuthController::class, 'registerSubmit']);
Route::post('/loginSubmit', [App\Http\Controllers\AuthController::class, 'loginSubmit']);
