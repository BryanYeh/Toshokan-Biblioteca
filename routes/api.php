<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LibrariansController;
use App\Http\Controllers\Admin\PatronsController;
use App\Http\Controllers\Admin\VisitorsController;
use App\Http\Controllers\Admin\BooksController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\LendController;
use App\Http\Controllers\Admin\InvitationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('invitation/{code}/email/{email}', InvitationController::class)
    ->whereAlphaNumeric('code')
    ->where('email','^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$')
    ->middleware(['guest'])
    ->name('invitation');

Route::post('invitation/accept',[InvitationController::class,'accept'])
    ->middleware(['guest'])
    ->name('accept');

Route::get('librarians', LibrariansController::class);
Route::group(['prefix' => 'librarian'], function () {
    Route::delete('delete/{uuid}', [LibrariansController::class,'delete']);
    Route::post('toggle/{uuid}/{status}', [LibrariansController::class,'toggle']);
    Route::post('invite', [LibrariansController::class,'invite']);
    Route::get('{uuid}', [LibrariansController::class,'show']);
});

Route::get('books', BooksController::class);
Route::group(['prefix' => 'book'], function () {
    Route::post('update/{id}', [BooksController::class,'update']);
    Route::post('create', [BooksController::class,'save']);
    Route::get('{uuid}', [BooksController::class,'show']);
});

Route::get('locations', LocationController::class);
Route::group(['prefix' => 'location'], function () {
    Route::post('update/{uuid}', [LocationController::class,'update']);
    Route::post('create', [LocationController::class,'save']);
    Route::get('{uuid}', [LocationController::class,'show']);
});

Route::get('patrons', PatronsController::class);
Route::group(['prefix' => 'location'], function () {
    Route::post('update/{uuid}', [PatronsController::class,'update']);
    Route::post('downgrade/{uuid}', [PatronsController::class,'downgrade']);
    Route::get('{uuid}', [PatronsController::class,'show']);
});

Route::get('visitors', VisitorsController::class);
Route::group(['prefix' => 'visitor'], function(){
    Route::post('upgrade/{uuid}', [VisitorsController::class,'upgrade']);
    Route::get('{uuid}', [VisitorsController::class,'view']);
});


Route::get('/lend', LendController::class)->name('lend');
Route::post('/lend/patron', [LendController::class,'load'])->name('lend.load');
Route::post('/lend/book',[LendController::class,'checkout'])->name('lend.book');
Route::get('/lend/book/return',[LendController::class,'checkinView'])->name('lend.return.view');
Route::post('/lend/book/return',[LendController::class,'checkin'])->name('lend.return');
