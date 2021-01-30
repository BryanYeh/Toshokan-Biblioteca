<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LibrarianController extends Controller
{
    public function create()
    {
        return view('dashboard.librarian_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:8',
            'username' => 'required|string|min:5|max:255|unique:users',
            'email' => 'email|nullable',
            'dob' => 'date|nullable'
        ]);

        User::create([
            'user_type' => 'librarian',
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

        return redirect()->route('librarians');
    }

    public function edit(Request $request)
    {
        return 'editing '. $request->id;
    }
}
