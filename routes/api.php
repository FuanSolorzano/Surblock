<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\SalesDetailController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\CartController;
use Illuminate\Http\Request;

// Rutas públicas para registro y login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas públicas para ver productos y agregar al carrito
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::get('/products/search', [ProductController::class, 'search']);
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');

// Rutas protegidas por Sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Obtener información del usuario autenticado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Rutas protegidas del carrito y recursos
    Route::post('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

    Route::apiResource('products', ProductController::class);
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('sales', SaleController::class);
    Route::apiResource('salesdetails', SalesDetailController::class);

    // Rutas de compra/checkout (por implementar)
    Route::post('/checkout', [SaleController::class, 'checkout'])->name('checkout');

    // Ruta para cerrar sesión (logout)
    Route::post('/logout', [AuthController::class, 'logout']);
});
