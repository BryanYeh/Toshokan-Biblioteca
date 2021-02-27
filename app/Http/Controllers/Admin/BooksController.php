<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books;
use Inertia\Inertia;

class BooksController extends Controller
{
    // list of books
    public function __invoke()
    {
        $books = Books::select('title','edition','isbn','image','id')->paginate(25);
        return Inertia::render('Admin/Books/List', ['books' => $books]);
    }

    public function view(Request $request)
    {
        //
    }

    public function edit(Request $request)
    {
        //
    }

    public function update(Request $request)
    {
        //
    }
}
