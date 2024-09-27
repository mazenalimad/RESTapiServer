<?php

use App\Http\Controllers\api\v1\CastMembersController;
use App\Http\Controllers\api\v1\DirectorsController;
use App\Http\Controllers\api\v1\DomainsController;
use App\Http\Controllers\api\v1\GenresController;
use App\Http\Controllers\api\v1\MoviesController;
use App\Http\Controllers\api\v1\LanguagesController;
use App\Http\Controllers\api\v1\FavoriteController;
use App\Http\Controllers\AuthController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware(['auth:sanctum']);


// v1

Route::group(['prefix'=> 'v1', 'namespace' => 'App\Http\Controllers\api\v1'/*, 'middleware' => ['auth:sanctum']*/], function () {
    Route::get('/movies', [MoviesController::class, 'index'])->name('movies');
    Route::post('/movies', [MoviesController::class, 'store'])->name('store')->middleware(['auth:sanctum', 'admin']);
    Route::get('/movies/{id}', [MoviesController::class, 'show'])->name('show')->middleware(['auth:sanctum', 'admin']);
    Route::put('/movies/{id}', [MoviesController::class, 'update'])->name('update')->middleware(['auth:sanctum', 'admin']);
    Route::delete('/movies/{id}', [MoviesController::class, 'destroy'])->name('destroy')->middleware(['auth:sanctum', 'admin']);


    Route::get('/casts', [CastMembersController::class,'index'])->name('casts')->middleware(['auth:sanctum', 'admin']);
    Route::get('/directors', [DirectorsController::class, 'index'])->name('directors')->middleware(['auth:sanctum', 'admin']);
    Route::get('/domains', [DomainsController::class, 'index'])->name('domains')->middleware(['auth:sanctum', 'admin']);
    Route::get('/genres', [GenresController::class, 'index'])->name('genres')->middleware(['auth:sanctum', 'admin']);
    Route::get('/languages', [LanguagesController::class, 'index'])->name('Languages')->middleware(['auth:sanctum', 'admin']);

    Route::get('/favorites', [FavoriteController::class, 'index'])->middleware(['auth:sanctum']);
    Route::post('/favorites', [FavoriteController::class, 'store'])->middleware(['auth:sanctum']);
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->middleware(['auth:sanctum']);
});