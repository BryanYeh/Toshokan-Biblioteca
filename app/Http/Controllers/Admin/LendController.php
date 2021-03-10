<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class LendController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Admin/Lend/View');
    }

    public function load(Request $request)
    {
        return Inertia::render('Admin/Lend/View',User::where('card_number',$request->number)->firstOrFail());
    }
}
