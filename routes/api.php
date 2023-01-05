<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\Api\AuthController;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */



Route::group(['middleware' => 'log.route'], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('api.authenticate');
    Route::post('/register', [AuthController::class, 'register'])->name('api.register');
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});

//Route::resource('posts', PostController::class)->middleware('log.route');

Route::delete('posts/delteAllPost',[PostController::class, 'destroyAllPost'])->middleware('log.route')->name('api.delete');

Route::get('posts/pdf', [PostController::class, 'generatePdf'])->middleware('log.route');
Route::get('posts/{post}', [PostController::class, 'show'])->middleware('log.route');
Route::post('posts', [PostController::class, 'store'])->middleware('log.route');

