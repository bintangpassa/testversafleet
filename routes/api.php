<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('chart')->group(function () {
    Route::get('/', [ChartController::class, 'index']);
    Route::get('/{user}', [ChartController::class, 'show']);
    Route::post('/add', [ChartController::class, 'add']);
    Route::get('/totalprice/{user}', [ChartController::class, 'totalPrice']);
});
 
// Route::apiResource('chart', ChartController::class);
Route::apiResource('product', ProductController::class);
Route::apiResource('promotion', PromotionController::class);
Route::apiResource('user', UserController::class);