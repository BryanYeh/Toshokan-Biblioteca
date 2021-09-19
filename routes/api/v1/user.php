<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\Admin\InvitationController;
use App\Http\Controllers\AuthController;

Route::group(['prefix' => 'books'], function () {
    Route::get('/', BooksController::class);
    Route::get('{slug}', [BooksController::class,'show']);
});

Route::get('search', [BooksController::class, 'search']);

Route::post('register', [AuthController::class, 'register']); // creates visitor
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);


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
