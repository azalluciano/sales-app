<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;

// Routes publiques (inscription et connexion)
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Routes protégées par JWT
Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);

    // Routes pour les utilisateurs
    Route::apiResource('users', UserController::class);

    // Routes pour les clients
    Route::apiResource('clients', ClientController::class);

    // Routes pour les produits
    Route::apiResource('products', ProductController::class);

    // Routes pour les ventes
    Route::apiResource('sales', SaleController::class);

    // Route pour le rapport
    Route::get('reports/sales-by-client-and-product', [SaleController::class, 'salesByClient']);
});