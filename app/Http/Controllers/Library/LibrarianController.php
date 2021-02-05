<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LibrarianController extends Controller
{
    public function viewList()
    {
        $librarians = User::where('user_type', 'librarian')->select('first_name','last_name','username','id')->paginate(25);
        return view('dashboard.librarians', ['librarians' => $librarians]);
    }

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
        ]);

        User::create([
            'user_type' => 'librarian',
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('librarians');
    }

    public function edit(Request $request)
    {
        $librarian = User::where('id',$request->id)->first();
        return view('dashboard.librarian_edit',['librarian' => $librarian]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'email|nullable',
            'dob' => 'date|nullable'
        ]);

        User::find($request->id)->update($request->all());
        return redirect()->route('librarians');
    }
}
