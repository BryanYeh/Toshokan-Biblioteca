<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LibrariansController;
use App\Http\Controllers\Admin\PatronsController;
use App\Http\Controllers\Admin\VisitorsController;
use App\Http\Controllers\Admin\BooksController;
use App\Http\Controllers\Admin\LocationsController;
use App\Http\Controllers\Admin\SubjectsController;
use App\Http\Controllers\Admin\InvitationController;

Route::group(['prefix' => 'librarians'], function () {
    Route::get('/', LibrariansController::class);
    Route::post('/', [LibrariansController::class,'store']);
    Route::get('{hashid}', [LibrariansController::class,'show']);
    Route::put('{hashid}', [LibrariansController::class,'update']);
    Route::delete('{hashid}', [LibrariansController::class,'destroy']);
});

Route::group(['prefix' => 'books'], function () {
    Route::get('/', BooksController::class);
    Route::post('/', [BooksController::class,'store']);
    Route::get('{hashid}', [BooksController::class,'show']);
    Route::put('{hashid}', [BooksController::class,'update']);
    Route::delete('{hashid}', [BooksController::class,'destroy']);
});

Route::group(['prefix' => 'subjects'], function () {
    Route::get('/', SubjectsController::class);
    Route::post('/', [SubjectsController::class,'store']);
    Route::get('{hashid}', [SubjectsController::class,'show']);
    Route::put('{hashid}', [SubjectsController::class,'update']);
    Route::delete('{hashid}', [SubjectsController::class,'destroy']);
});

Route::group(['prefix' => 'locations'], function () {
    Route::get('/', LocationsController::class);
    Route::post('/', [LocationsController::class,'store']);
    Route::get('{hashid}', [LocationsController::class,'show']);
    Route::put('{hashid}', [LocationsController::class,'update']);
    Route::delete('{hashid}', [LocationsController::class,'destroy']);
});

Route::group(['prefix' => 'patrons'], function () {
    Route::get('/', PatronsController::class);
    Route::post('/', [PatronsController::class,'store']);
    Route::get('{hashid}', [PatronsController::class,'show']);
    Route::put('{hashid}', [PatronsController::class,'update']);
    Route::delete('{hashid}', [PatronsController::class,'destroy']);
});

Route::group(['prefix' => 'visitors'], function(){
    Route::get('/', VisitorsController::class);
    Route::get('{hashid}', [VisitorsController::class,'show']);
    Route::put('{hashid}', [VisitorsController::class,'update']);
    Route::delete('{hashid}', [VisitorsController::class,'destroy']);
});

Route::group(['prefix' => 'invitations'], function () {
    Route::get('{code}/email/{email}', InvitationController::class)
        ->whereAlphaNumeric('code')
        ->where('email','^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$')
        ->middleware(['guest'])
        ->name('invitation');

    Route::post('accept',[InvitationController::class,'accept'])
        ->middleware(['guest'])
        ->name('accept');
});
