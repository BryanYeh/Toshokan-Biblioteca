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
Route::get('/invitation/{code}/email/{email}', InvitationController::class)
    ->whereAlphaNumeric('code')
    ->where('email','^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$')
    ->middleware(['guest'])
    ->name('invitation');

Route::post('/invitation/accept',[InvitationController::class,'accept'])
    ->middleware(['guest'])
    ->name('accept');

Route::get('/librarians', LibrariansController::class);
Route::get('/librarians/{uuid}', [LibrariansController::class,'show']);
Route::delete('/librarians/delete/{id}', [LibrariansController::class,'remove']);
Route::post('/invite', [LibrariansController::class,'send']);

Route::get('/patrons', PatronsController::class)->name('patrons');
Route::get('/patrons/profile/{id}', [PatronsController::class,'view'])->name('patron.profile');
Route::get('/patrons/edit/{id}', [PatronsController::class,'edit'])->name('patron.edit');
Route::post('/patrons/edit/{id}', [PatronsController::class,'update'])->name('patron.update');
Route::post('/patrons/downgrade/{id}', [PatronsController::class,'downgrade'])->name('patron.downgrade');

Route::get('/visitors', VisitorsController::class)->name('visitors');
Route::get('/visitors/profile/{id}', [VisitorsController::class,'view'])->name('visitor.profile');
Route::get('/visitors/upgrade/{id}', [VisitorsController::class,'edit'])->name('visitor.edit');
Route::post('/visitors/upgrade/{id}', [VisitorsController::class,'upgrade'])->name('visitor.upgrade');

Route::get('/books', BooksController::class)->name('books');
Route::get('/books/details/{id}', [BooksController::class,'view'])->name('book.detail');
Route::get('/books/edit/{id}', [BooksController::class,'edit'])->name('book.edit');
Route::post('/books/update/{id}', [BooksController::class,'update'])->name('book.update');
Route::get('/books/create', [BooksController::class,'create'])->name('book.create');
Route::post('/books/create', [BooksController::class,'save'])->name('book.save');

Route::get('/locations', LocationController::class)->name('locations');
Route::get('/locations/details/{id}', [LocationController::class,'view'])->name('location.detail');
Route::get('/locations/edit/{id}', [BooksLocationControllerController::class,'edit'])->name('location.edit');
Route::post('/locations/update/{id}', [LocationController::class,'update'])->name('location.update');
Route::get('/locations/create', [LocationController::class,'create'])->name('location.create');
Route::post('/locations/create', [LocationController::class,'save'])->name('location.save');

Route::get('/lend', LendController::class)->name('lend');
Route::post('/lend/patron', [LendController::class,'load'])->name('lend.load');
Route::post('/lend/book',[LendController::class,'checkout'])->name('lend.book');
Route::get('/lend/book/return',[LendController::class,'checkinView'])->name('lend.return.view');
Route::post('/lend/book/return',[LendController::class,'checkin'])->name('lend.return');
