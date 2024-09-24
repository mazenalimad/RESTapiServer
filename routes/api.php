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


Route::group(['prefix'=> 'v1', 'namespace' => 'App\Http\Controllers\api\v1', 'middleware' => ['auth:sanctum']], function () {
    Route::apiResource('movies', MoviesController::class);

    Route::get('/casts', [CastMembersController::class,'index'])->name('casts');
    Route::get('/directors', [DirectorsController::class, 'index'])->name('directors');
    Route::get('/domains', [DomainsController::class, 'index'])->name('domains');
    Route::get('/genres', [GenresController::class, 'index'])->name('genres');
    Route::get('/languages', [LanguagesController::class, 'index'])->name('Languages')->middleware(['auth:sanctum']);

    Route::get('favorites', [FavoriteController::class, 'index']);
    Route::post('favorites', [FavoriteController::class, 'store']);
    Route::delete('favorites/{id}', [FavoriteController::class, 'destroy']);
});