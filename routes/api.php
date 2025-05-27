<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


// Routes pour les utilisateurs
Route::apiResource('users', UserController::class);