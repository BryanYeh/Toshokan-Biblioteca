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
    // lend book page
    public function __invoke()
    {
        return Inertia::render('Admin/Lend/View');
    }

    // load patron by card
    public function load(Request $request)
    {
        return Inertia::render('Admin/Lend/View',User::where('card_number',$request->card_number)->firstOrFail());
    }

    // checkout book to patron
    public function checkout(Request $request)
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

    // return book page
    public function checkinView()
    {
        return Inertia::render('Admin/Lend/Checkin');
    }

    // return book
    public function checkin(Request $request)
    {
        $bookLocation = BookLocation::where('barcode', $request->barcode)->firstOrFail();
        $lend = Lend::where('book_id',$bookLocation->id)->whereNull('returned_date')->firstOrFail();
        $lend->returned_date = Carbon::now();
        $lend->is_damaged = isset($request->is_damaged);
        $lend->notes = $request->notes;
        $lend->save();

        return redirect()->back()
            ->with('message', "Book has been returned!");
    }

}
