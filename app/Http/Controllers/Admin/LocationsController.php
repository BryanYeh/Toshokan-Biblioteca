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
        if(isset($request->sort) && count(explode(' ',$request->sort)) == 2){
            $sort = explode(' ',$request->sort);
            $column = Str::slug($sort[0],'_');
            $direction = $sort[1] === 'asc' ? 'ASC' : 'DESC';

            return response()->json(Location::select('uuid','name','address1','phone')
                            ->orderBy($column, $direction)
                            ->paginate(25)->withQueryString());
        }

        return response()->json(Location::select('uuid','name','address1','phone')
                        ->paginate(25)->withQueryString());
    }

    // location details
    public function show(Request $request)
    {
        $location = Location::where('uuid',$request->uuid)->first();

        if(!$location){
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
        $location = Location::where('id',$request->id)->firstOrFail();
        $location->update($request->all());

        return response()->json(['message'=>'Successfully updated location.']);
    }

    // save location
    public function save(Request $request)
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

        return response()->json(['message'=>"Successfully added location."]);
    }
}
