<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BookLocation;
use App\Models\Lend;
use Carbon\Carbon;

class LendController extends Controller
{
    // load patron by card
    public function load(Request $request)
    {
        $patron = User::where('card_number',$request->card_number)->first();

        if(!$patron){
            return response()->json(['message' => 'Unable to find card owner'], 404);
        }

        return response()->json($patron);
    }

    // checkout book to patron
    public function checkout(Request $request)
    {
        $patron = User::where('card_number',$request->card_number)->first();
        if(!$patron){
            return response()->json(['message' => 'Unable to find card owner'], 404);
        }

        $book = BookLocation::where('barcode',$request->barcode)->with('book')->first();
        if(!$book){
            return response()->json(['message' => 'Unable to find book'], 404);
        }

        $lend = new Lend();
        $lend->user_id = $patron->id;
        $lend->book_id = $book->id;
        $lend->lend_date = Carbon::now();
        $lend->save();

        return response()->json($book);
    }

    // return book
    public function checkin(Request $request)
    {
        $bookLocation = BookLocation::where('barcode', $request->barcode)->first();
        if(!$bookLocation){
            return response()->json(['message' => 'Unable to find book'], 404);
        }

        $lend = Lend::where('book_id',$bookLocation->id)->whereNull('returned_date')->first();
        if(!$lend){
            return response()->json(['message' => 'The book was never lended out'], 404);
        }

        $lend->returned_date = Carbon::now();
        $lend->is_damaged = isset($request->is_damaged);
        $lend->notes = $request->notes;
        $lend->save();

        return response()->json(['message'=>'Book has been returned!']);
    }

    public function bookFees(Request $request)
    {
        $patron = User::select('id')->where('uuid',$request->uuid)->first();

        if(!$patron){
            return response()->json(['message' => 'Patron not found'], 404);
        }

        $returned_books = Lend::whereNotNull('returned_date')->where('user_id',$patron->id)->with('location')->get();

        $late_fees = 0;
        $damaged_fees = 0;
        foreach($returned_books as $book){
            $lend_date = Carbon::parse($book->lend_date);
            $returned_date = $book->returned_date;
            $days_late = $lend_date->diffInDays($returned_date);
            $late_fees += round($days_late * .25 - $book->late_fee_paid, 2);

            if($book->is_damaged){
                $damaged_fees += round($book->location->price * .10 - $book->damaged_fee_paid, 2);
            }

        }
        return response()->json(['late_fee'=>$late_fees,'damaged_fee'=>$damaged_fees]);
    }
}
