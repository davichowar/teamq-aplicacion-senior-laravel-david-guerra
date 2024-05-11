<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MovieController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckUserRole;
use App\Http\Controllers\MovieImageController;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/movies', [MovieController::class,'showAll']);
    Route::get('/movies/{id}', [MovieController::class,'show']);
    Route::get('/movies/query={string}', [MovieController::class,'search']);
    Route::post('/movies', [MovieController::class,'store'])->middleware(CheckUserRole::class);
    Route::delete('/movies/{id}', [MovieController::class,'destroy'])->middleware(CheckUserRole::class);
    Route::patch('/movies/{id}', [MovieController::class,'updatePartial'])->middleware(CheckUserRole::class);
    Route::put('/movies/{id}', [MovieController::class,'updateTotal'])->middleware(CheckUserRole::class);

    Route::post('/movies/{id}/imagen', [MovieImageController::class, 'store'])->name('movies.image.store');
    Route::get('/movies/{id}/imagen', [MovieImageController::class, 'show'])->name('movies.image.show');

    Route::get('users', [UserController::class,'index'])->middleware(CheckUserRole::class);
    Route::get('users/{id}', [UserController::class,'show'])->middleware(CheckUserRole::class);
    Route::post('users', [UserController::class,'store'])->middleware(CheckUserRole::class);
    Route::put('users/{id}', [UserController::class,'update'])->middleware(CheckUserRole::class);
    Route::delete('users/{id}', [UserController::class,'destroy'])->middleware(CheckUserRole::class);
});