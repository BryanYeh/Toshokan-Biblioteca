<?php

use App\Http\Controllers\Library\LibrariansListController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Library\LibrarianController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/librarians', [LibrariansListController::class, 'view'])
        ->middleware(['auth'])
        ->name('librarians');

Route::get('/librarians/create', [LibrarianController::class,'create'])
            ->middleware('auth')
            ->name('librarian.create');

Route::post('/librarians/create', [LibrarianController::class, 'store'])
            ->middleware('auth')
            ->name('librarian.create.store');

Route::get('/librarians/edit/{id}', [LibrarianController::class,'edit'])
            ->middleware('auth')
            ->name('librarian.edit');
