<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LocationController extends Controller
{
    // list of locations
    public function __invoke()
    {
        $locations = Location::select('id','name','address1','phone')->paginate(25);
        return Inertia::render('Admin/Locations/List', ['locations' => $locations]);
    }

    // location details
    public function details(Request $request)
    {
        $location = Location::where('id',$request->id)->firstOrFail();
        return Inertia::render('Admin/Locations/Detail', ['location' => $location]);
    }

    // edit location page
    public function edit(Request $request)
    {
        $location = Location::where('id',$request->id)->firstOrFail();
        return Inertia::render('Admin/Locations/Edit', ['location' => $location]);
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

        return redirect()->back()->with('message', "Successfully updated location.");
    }
    // create location page
    public function create(Request $request)
    {
        return Inertia::render('Admin/Locations/New');
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

        return redirect()->back()->with('message', "Successfully added location.");
    }
}
