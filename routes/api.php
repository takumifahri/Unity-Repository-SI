<?php

use App\Http\Controllers\Api\AuthControllerApi;
use App\Http\Controllers\Api\AuthCoontrollerApi;
use App\Http\Controllers\Api\CatalogControllerApi;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProfileController;
use Illuminate\Auth\Middleware\Authenticate;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/auth/register', [AuthControllerApi::class, 'Register']);
Route::post('/auth/login', [AuthControllerApi::class, 'Login']);
Route::post('/auth/logout', [AuthControllerApi::class, 'Logout']);

Route::prefix('/catalog')->group(function () {
    Route::get('/', [CatalogControllerApi::class, 'index']);
    Route::post('/store', [CatalogControllerApi::class, 'store']);
    Route::post('/update/{id}', [CatalogControllerApi::class, 'updateCatalog']);
    Route::post('/addStock/{id}', [CatalogControllerApi::class, 'addStockCatalog']);
    Route::delete('/admin/{id}', [CatalogControllerApi::class, 'destroyAdmin']);
});