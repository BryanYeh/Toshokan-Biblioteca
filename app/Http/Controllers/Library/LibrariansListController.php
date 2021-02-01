<?php

namespace App\Http\Controllers\Library;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class LibrariansListController extends Controller
{
    public function view()
    {
        $librarians = User::where('user_type', 'librarian')->select('first_name','last_name','username','id')->paginate(25);
        return view('dashboard.librarians', ['librarians' => $librarians]);
    }
}
