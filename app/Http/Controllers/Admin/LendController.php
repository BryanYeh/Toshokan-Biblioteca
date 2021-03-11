<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\BookLocation;
use App\Models\Lend;
use Carbon\Carbon;

class LendController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Admin/Lend/View');
    }

    public function load(Request $request)
    {
        return Inertia::render('Admin/Lend/View',User::where('card_number',$request->card_number)->firstOrFail());
    }

    public function lend(Request $request)
    {
        $user = User::where('card_number',$request->card_number)->first();
        $book = BookLocation::where('barcode',$request->barcode)->with('book')->firstOrFail();
        $lend = new Lend();
        $lend->user_id = $user->id;
        $lend->book_id = $book->id;
        $lend->lend_date = Carbon::now();
        $lend->save();
        return Inertia::render('Admin/Lend/View', $book );
    }
}
