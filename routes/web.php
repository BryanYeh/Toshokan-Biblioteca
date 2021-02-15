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

Route::get('/invitation/{code}/email/{email}', InvitationController::class)->whereAlphaNumeric('code')->where('email','^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$')->middleware(['guest'])->name('invitation');

Route::post('/invitation/accept',[InvitationController::class,'accept'])->middleware(['guest'])->name('accept');



Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/invite', LibrariansController::class)->name('invite');
    Route::post('/invite', [LibrariansController::class,'send'])->name('inviteLibrarian');

    Route::get('/librarians', [LibrariansController::class,'view'])->name('view');
    Route::get('/librarian/edit/{id}', [LibrariansController::class,'edit'])->name('edit.librarian');

    Route::get('/patrons', PatronsController::class)->name('patrons');
    Route::get('/patrons/edit/{id}', [PatronsController::class,'edit'])->name('edit.patron');

    Route::get('/visitors', VisitorsController::class)->name('visitors');
    Route::get('/visitors/edit/{id}', [VisitorsController::class,'edit'])->name('edit.visitor');
});
