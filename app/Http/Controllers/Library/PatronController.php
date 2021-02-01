<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PatronController extends Controller
{
    public function viewList()
    {
        $patrons = User::where('user_type', 'patron')->select('first_name','last_name','username','id')->paginate(25);
        return view('dashboard.patrons', ['patrons' => $patrons]);
    }
}
