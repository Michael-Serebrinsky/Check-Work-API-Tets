<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ProductsApiController;
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

// Products API CRUD
Route::post('/createProduct',[ ProductsApiController::class, 'createProduct']);
Route::delete('/delete/{id}',[ ProductsApiController::class, 'deleteProduct']);
Route::put('/update/{id}',[ ProductsApiController::class, 'updateProduct']);
Route::get('/get-all-products',[ ProductsApiController::class, 'getAllProducts']);
Route::get('/getProduct/{id}',[ ProductsApiController::class, 'getProduct']);
//  END Products API CRUD