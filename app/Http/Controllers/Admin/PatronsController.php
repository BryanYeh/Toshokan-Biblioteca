<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;

class PatronsController extends Controller
{
    // list of patrons
    public function __invoke(Request $request)
    {
        // order by column from $request->sort (column name, sorting direction)
        if(isset($request->sort) && count(explode(' ',$request->sort)) == 2){
            $sort = explode(' ',$request->sort);
            $column = Str::slug($sort[0],'_');
            $direction = $sort[1] === 'asc' ? 'ASC' : 'DESC';

            return response()->json(User::where('user_type', 'patron')
                            ->select('first_name','last_name','card_number','address_confirmed_at','uuid')
                            ->orderBy($column, $direction)
                            ->paginate(25)->withQueryString());
        }

        return response()->json(User::where('user_type', 'patron')
                        ->select('first_name','last_name','card_number','address_confirmed_at','uuid')
                        ->paginate(25)->withQueryString());
    }

    // view patron page
    public function view(Request $request)
    {
        $patron = User::where('uuid',$request->uuid)->first();

        if(!$patron){
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json($patron);
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

        User::where('uuid',$request->uuid)->update($request->all());
        return response()->json(['success'=>'Patron successfully updated']);
    }

    // turn patron into visitor
    public function downgrade(Request $request)
    {
        $patron = User::where('uuid',$request->uuid)->first();
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

        return response()->json(['message'=> "$patron->first_name $patron->last_name has been downgraded to a visitor"]);
    }
}
