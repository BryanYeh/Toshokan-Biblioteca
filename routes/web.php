<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Library\LibrarianController;
use App\Http\Controllers\Library\PatronController;
use App\Http\Controllers\Library\BookController;

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

// librarians
Route::get('/librarians', [LibrarianController::class, 'viewList'])
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

Route::post('/librarians/edit/{id}', [LibrarianController::class,'update'])
            ->middleware('auth')
            ->name('librarian.update');
// patrons
Route::get('/patrons', [PatronController::class, 'viewList'])
            ->middleware(['auth'])
            ->name('patrons');

Route::get('/patrons/create', [PatronController::class,'create'])
            ->middleware('auth')
            ->name('patron.create');

Route::post('/patrons/create', [PatronController::class, 'store'])
            ->middleware('auth')
            ->name('patron.create.store');

Route::get('/patrons/edit/{id}', [PatronController::class,'edit'])
            ->middleware('auth')
            ->name('patron.edit');

Route::post('/patrons/edit/{id}', [PatronController::class,'update'])
            ->middleware('auth')
            ->name('patron.update');

// books
Route::get('/books', [BookController::class, 'viewList'])
            ->middleware(['auth'])
            ->name('books');

Route::get('/books/create', [BookController::class,'create'])
            ->middleware('auth')
            ->name('book.create');

Route::post('/books/create', [BookController::class, 'store'])
            ->middleware('auth')
            ->name('book.create.store');

Route::get('/books/edit/{id}', [BookController::class,'edit'])
            ->middleware('auth')
            ->name('book.edit');

Route::post('/books/edit/{id}', [BookController::class,'update'])
            ->middleware('auth')
            ->name('book.update');
