<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;

class VisitorsController extends Controller
{
    // list of visitors
    public function __invoke()
    {
        $visitors = User::where('user_type', 'visitor')->select('first_name','last_name','email','id')->paginate(25);
        return $visitors;
    }

    // view visitor profile
    public function view(Request $request)
    {
        $visitor = User::where('id',$request->id)->first();
        return $visitor;
    }

    // upgrading visitor into patron page
    public function edit(Request $request)
    {
        $visitor = User::where('id',$request->id)->first();
        return $visitor;
    }

    // upgrade visitor to a patron
    public function upgrade(Request $request)
    {
        $request->validate([
            'card_number' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'dob' => 'required|date',
            'address1' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|max:255'
        ]);

        $visitor = User::find($request->id);
        $data = $request->all();
        $data['user_type'] = 'patron';
        $data['address_confirmed_at'] = Carbon::now();
        $visitor->update($data);

        return response()->json(['message'=>"$request->first_name $request->last_name is now a patron."]);
    }
}
