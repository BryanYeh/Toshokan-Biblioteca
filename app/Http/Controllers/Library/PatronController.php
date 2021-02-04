<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PatronController extends Controller
{
    public function viewList()
    {
        $patrons = User::where('user_type', 'patron')->select('first_name','last_name','username','id')->paginate(25);
        return view('dashboard.patrons', ['patrons' => $patrons]);
    }

    public function create()
    {
        return view('dashboard.patron_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:5',
            'username' => 'required|numeric|unique:users',
            'email' => 'email|nullable',
            'dob' => 'date|nullable',
            'address1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
        ]);

        User::create([
            'user_type' => 'patron',
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'dob' => $request->dob,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'phone' => $request->phone,
        ]);

        return redirect()->route('patrons');
    }

    public function edit(Request $request)
    {
        $patron = User::where('id',$request->id)->first();
        return view('dashboard.patron_edit',['patron' => $patron]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|numeric|unique:users',
            'email' => 'email|nullable',
            'dob' => 'date|nullable',
            'address1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
        ]);

        User::find($request->id)->update($request->all());
        return redirect()->route('patrons');
    }
}
