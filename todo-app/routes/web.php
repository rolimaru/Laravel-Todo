<?php

use Illuminate\Support\Facades\Route;
use app\Http\Controllers\TodoController;
use app\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/login', function () {
//     return view('login');
// });
// Route::get('/register', function () {
//     return view('register');
// });
Route::middleware('auth')->group(
    function () {
        Route::get('/', function () {
            $userName = Auth::user()->name; // Ensure this column exists and is named correctly
            return view('welcome', ['userName' => $userName]);
        });

        Route::get('/admin', [App\Http\Controllers\UserController::class, 'admin'])->name('admin');

        Route::get('/todo', [App\Http\Controllers\TodoController::class, 'index'])->name('todo');
        Route::post('/add', [App\Http\Controllers\TodoController::class, 'create']);
        Route::get('/show/{id}', [App\Http\Controllers\TodoController::class, 'showById']);
        Route::patch('/edit/{id}', [App\Http\Controllers\TodoController::class, 'update']);
        Route::delete('/delete/{id}', [App\Http\Controllers\TodoController::class, 'destroy']);
        Route::patch('/markAsDone/{id}', [App\Http\Controllers\TodoController::class, 'markAsDone']);
        Route::patch('/markAsTodo/{id}', [App\Http\Controllers\TodoController::class, 'markAsTodo']);
    }
);
//logout
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');


//for Login
Route::post('/registerSubmit', [App\Http\Controllers\AuthController::class, 'registerSubmit']);
Route::get('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');

Route::post('/loginSubmit', [App\Http\Controllers\AuthController::class, 'loginSubmit']);
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
