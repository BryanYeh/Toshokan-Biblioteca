<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LibrariansController;
use App\Http\Controllers\Admin\PatronsController;
use App\Http\Controllers\Admin\VisitorsController;
use App\Http\Controllers\Admin\BooksController;
use App\Http\Controllers\Admin\LocationsController;
use App\Http\Controllers\Admin\SubjectsController;

Route::group(['prefix' => 'librarians'], function () {
    Route::get('/', LibrariansController::class);
    Route::post('/', [LibrariansController::class,'invite']);
    Route::get('{id}', [LibrariansController::class,'show']);
    Route::put('{id}', [LibrariansController::class,'update']);
    Route::delete('{id}', [LibrariansController::class,'destroy']);
});

Route::group(['prefix' => 'books'], function () {
    Route::get('/', BooksController::class);
    Route::post('/', [BooksController::class,'store']);
    Route::get('{id}', [BooksController::class,'show']);
    Route::put('{id}', [BooksController::class,'update']);
    Route::delete('{id}', [BooksController::class,'destroy']);
});

Route::group(['prefix' => 'subjects'], function () {
    Route::get('/', SubjectsController::class);
    Route::post('/', [SubjectsController::class,'store']);
    Route::get('{id}', [SubjectsController::class,'show']);
    Route::put('{id}', [SubjectsController::class,'update']);
    Route::delete('{id}', [SubjectsController::class,'destroy']);
});

Route::group(['prefix' => 'locations'], function () {
    Route::get('/', LocationsController::class);
    Route::post('/', [LocationsController::class,'store']);
    Route::get('{id}', [LocationsController::class,'show']);
    Route::put('{id}', [LocationsController::class,'update']);
    Route::delete('{id}', [LocationsController::class,'destroy']);
});

Route::group(['prefix' => 'patrons'], function () {
    Route::get('/', PatronsController::class);
    // Route::post('/', [PatronsController::class,'store']);
    Route::get('{id}', [PatronsController::class,'show']);
    Route::put('{id}', [PatronsController::class,'update']);
    Route::delete('{id}', [PatronsController::class,'destroy']);
    Route::post('{id}/downgrade', [PatronsController::class,'downgrade']);
});

Route::group(['prefix' => 'visitors'], function(){
    Route::get('/', VisitorsController::class);
    Route::get('{id}', [VisitorsController::class,'show']);
    Route::put('{id}', [VisitorsController::class,'update']);
    Route::delete('{id}', [VisitorsController::class,'destroy']);
    Route::post('{id}/upgrade', [VisitorsController::class,'upgrade']);
});
