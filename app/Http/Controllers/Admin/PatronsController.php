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
        $valid_columns = ['id', 'username', 'email', 'first_name', 'last_name', 'card_number', 'address1', 'country', 'postal_code'];
        if (
            $request->has('sortCol') && $request->has('sortOrder')
            && in_array(Str::slug($request->query('sortCol'), '_'), $valid_columns)
        ) {
            $column = Str::slug($request->query('sortCol'), '_');
            $direction = $request->query('sortCol') === 'asc' ? 'ASC' : 'DESC';

            $patrons = User::where('user_type', 'patron')
                ->orderBy($column, $direction)->paginate(env('PER_PAGE'))->withQueryString();

            return response()->json($patrons);
        }

        $patrons = User::where('user_type', 'patron')
            ->paginate(env('PER_PAGE'));

        return response()->json($patrons);
    }

    // view patron page
    public function show(Request $request)
    {
        $patron = User::where('id', $request->id)
            ->with('books.copy.location')
            ->with('books.copy.book')
            ->first();

        if (!$patron) {
            return response()->json(['message' => 'Patron not found'], 404);
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
            'address1' => 'required|string|max:255',
            'address2' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address_confirmed_at' => 'required|date'
        ]);

        User::where('id', $request->id)->update($request->all());
        return response()->json(['success' => 'Patron successfully updated']);
    }

    // delete location
    public function destroy(Request $request)
    {
        $patron = User::where('id', $request->id)->first();
        if (!$patron) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(null, 204);
    }

    // turn patron into visitor
    public function downgrade(Request $request)
    {
        $patron = User::where('id', $request->id)->first();
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
        ]);

        return response()->json(['message' => "$patron->first_name $patron->last_name has been downgraded to a visitor"]);
    }
}
