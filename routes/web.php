<?php

use Illuminate\Support\Facades\Route;
/*
*Toutes les requêtes web seront redirigées vers la vue
*/
Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
