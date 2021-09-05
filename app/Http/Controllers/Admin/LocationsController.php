<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LocationsController extends Controller
{
    // list of locations
    public function __invoke(Request $request)
    {
        // order by column from $request->sort (column name, sorting direction)
        $valid_columns = ['id', 'name', 'address1', 'address2', 'city', 'state', 'postal_code', 'country', 'phone'];
        if (
            $request->has('sortCol') && $request->has('sortOrder')
            && in_array(Str::slug($request->query('sortCol'), '_'), $valid_columns)
        ) {
            $column = Str::slug($request->query('sortCol'), '_');
            $direction = $request->query('sortCol') === 'asc' ? 'ASC' : 'DESC';

            $locations = Location::orderBy($column, $direction)->paginate(env('PER_PAGE'))->withQueryString();

            return response()->json($locations);
        }

        $locations = Location::paginate(env('PER_PAGE'));

        return response()->json($locations);
    }

    // create location
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|required',
            'address1' => 'string|required',
            'address2' => 'string|nullable',
            'city' => 'string|required',
            'state' => 'string|nullable',
            'postal_code' => 'string|required',
            'country' => 'string|required',
            'phone' => 'string|required'
        ]);

        $location = new Location();
        $location->name = $request->name;
        $location->address1 = $request->address1;
        $location->address2 = $request->address2;
        $location->city = $request->city;
        $location->state = $request->state;
        $location->postal_code = $request->postal_code;
        $location->phone = $request->phone;
        $location->save();

        return response()->json(['message' => "Successfully created location.", 'id' => $location->id], 201);
    }

    // location details
    public function show(Request $request)
    {
        $location = Location::where('id', $request->id)->first();

        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }

        return response()->json($location);
    }

    // update location page
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'string|required',
            'address1' => 'string|required',
            'address2' => 'string|nullable',
            'city' => 'string|required',
            'state' => 'string|nullable',
            'postal_code' => 'string|required',
            'country' => 'string|required',
            'phone' => 'string|required'
        ]);
        $location = Location::where('id', $request->id)->firstOrFail();
        $location->update($request->all());

        return response()->json(['message' => 'Successfully updated location.']);
    }
}
