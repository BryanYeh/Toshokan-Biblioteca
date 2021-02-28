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

    // view book info with locations
    public function view(Request $request)
    {
        $book = Books::where('id',$request->id)->with('locations')->firstOrFail();
        return Inertia::render('Admin/Books/Detail', ['book' => $book]);
    }

    // show book form
    public function edit(Request $request)
    {
        //
    }

    // update book
    public function update(Request $request)
    {
        //
    }

    // show create book form
    public function create(Request $request)
    {
        //
    }

    // save the book
    public function save(Request $request)
    {
        //
    }
}
