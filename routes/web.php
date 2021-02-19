<?php

use App\Http\Controllers\Admin\InvitationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\LibrariansController;
use App\Http\Controllers\Admin\PatronsController;
use App\Http\Controllers\Admin\VisitorsController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/invitation/{code}/email/{email}', InvitationController::class)
    ->whereAlphaNumeric('code')
    ->where('email','^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$')
    ->middleware(['guest'])
    ->name('invitation');

Route::post('/invitation/accept',[InvitationController::class,'accept'])
    ->middleware(['guest'])
    ->name('accept');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/librarians', LibrariansController::class)->name('librarians');
    Route::get('/librarians/profile/{id}', [LibrariansController::class,'view'])->name('librarian.profile');
    Route::post('/librarians/delete/{id}', [LibrariansController::class,'remove'])->name('librarian.delete');
    Route::get('/invite', [LibrariansController::class,'invite'])->name('librarian.invitation');
    Route::post('/invite', [LibrariansController::class,'send'])->name('librarian.invitation.send');

    Route::get('/patrons', PatronsController::class)->name('patrons');
    Route::get('/patrons/profile/{id}', [PatronsController::class,'view'])->name('patron.profile');
    Route::get('/patrons/edit/{id}', [PatronsController::class,'edit'])->name('patron.edit');
    Route::post('/patrons/edit/{id}', [PatronsController::class,'update'])->name('patron.update');
    Route::post('/patrons/downgrade/{id}', [PatronsController::class,'downgrade'])->name('patron.downgrade');

    Route::get('/visitors', VisitorsController::class)->name('visitors');
    Route::get('/visitors/profile/{id}', [VisitorsController::class,'view'])->name('visitor.profile');
    Route::get('/visitors/upgrade/{id}', [VisitorsController::class,'edit'])->name('visitor.edit');
    Route::post('/visitors/upgrade/{id}', [VisitorsController::class,'upgrade'])->name('visitor.upgrade');
});
