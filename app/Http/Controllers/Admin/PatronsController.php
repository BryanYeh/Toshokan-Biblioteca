<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class PatronsController extends Controller
{
    // list of patrons
    public function __invoke()
    {
        $patrons = User::where('user_type', 'patron')->select('first_name','last_name','card_number','address_confirmed_at','id')->paginate(25);
        return Inertia::render('Admin/Owner/Patrons', ['patrons' => $patrons]);
    }

    // view edit patron page
    public function edit(Request $request)
    {
        $patron = User::where('id',$request->id)->first();
        return $patron;
        // return Inertia::render('Admin/Owner/PatronEdit',['patron' => $patron]);
    }

    // update patron
    public function update(Request $request)
    {
        $request->validate([
            'card_number' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'dob' => 'required|date',
            'address_1' => 'required|string|max:255',
            'address_2' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address_confirmed_at' => 'required|date'
        ]);

        User::find($request->id)->update($request->all());
        return redirect()->route('edit.patron',['id'=>$request->id])->with('success', 'Patron successfully updated');
    }

    // turn patron into visitor
    public function downgrade(Request $request)
    {
        $patron = User::where('id',$request->id)->first();
        $patron->update([
            'user_type' => 'visitor',
            'card_number' => null,
            'dob' => null,
            'address_1' => null,
            'address_2' => null,
            'city' => null,
            'state' => null,
            'postal_code' => null,
            'country' => null,
            'phone' => null,
            'address_confirmed_at' => null
        ]);

        return redirect()->route('edit.visitor',['id' => $request->id])->with('success', 'Patron successfully downgraded to visitor');
    }
}
