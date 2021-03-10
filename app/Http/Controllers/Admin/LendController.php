<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LendController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Admin/Lend/View');
    }
}
