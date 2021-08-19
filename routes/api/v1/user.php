<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::group(['prefix' => 'books'], function () {
    Route::get('/', BookController::class);
    Route::get('{hashid}', [BookController::class,'show']);
});
