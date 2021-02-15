<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class VisitorsController extends Controller
{
    public function __invoke()
    {
        $visitors = User::where('user_type', 'visitor')->select('first_name','last_name','email','id')->paginate(25);
        return Inertia::render('Admin/Owner/Visitors', ['visitors' => $visitors]);
    }

    public function edit(Request $request)
    {

    }
}
