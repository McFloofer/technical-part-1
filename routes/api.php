<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::prefix('clients')->group(function () {
    Route::get('/',               [ClientController::class, 'index']);
    Route::post('/',              [ClientController::class, 'store']);
    Route::get('/{id}',           [ClientController::class, 'show']);
    Route::put('/{id}',           [ClientController::class, 'update']);
    Route::delete('/{id}',        [ClientController::class, 'destroy']);
    Route::post('/store-details', [ClientController::class, 'storeClientDetails']);
});