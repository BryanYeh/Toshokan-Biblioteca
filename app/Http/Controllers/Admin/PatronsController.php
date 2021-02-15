<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class PatronsController extends Controller
{
    public function __invoke()
    {
        $patrons = User::where('user_type', 'patron')->select('first_name','last_name','card_number','address_confirmed_at','id')->paginate(25);
        return Inertia::render('Admin/Owner/Patrons', ['patrons' => $patrons]);
    }

    public function edit(Request $request)
    {

    }
}
