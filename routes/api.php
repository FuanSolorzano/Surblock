<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\SalesDetailController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;

// Rutas públicas para registro y login
Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);

// Rutas protegidas por Sanctum
Route::middleware("auth:sanctum")->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('products', ProductController::class);
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('sales', SaleController::class);
    Route::apiResource('salesdetails', SalesDetailController::class);

    // Ruta para logout
    Route::post('/logout', [AuthController::class, 'logout']);
});
