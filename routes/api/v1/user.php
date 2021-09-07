<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Admin\InvitationController;

Route::group(['prefix' => 'books'], function () {
    Route::get('/', BookController::class);
    Route::get('{hashid}', [BookController::class,'show']);
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
