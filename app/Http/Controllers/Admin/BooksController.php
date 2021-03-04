<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books;
use App\Models\Location;
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

    // show edit book form
    public function edit(Request $request)
    {
        $book = Books::where('books.id',$request->id)->with('locations.library')->firstOrFail();
        $libraries = Location::select(['id','name'])->get();
        return Inertia::render('Admin/Books/Edit', ['book' => $book, 'libraries' => $libraries]);
    }

    // update book
    public function update(Request $request)
    {
        dd($request->all());
        $request->validate([
            'title' => 'required|string',
            'isbn' => 'required|string',
            'edition' => 'string',
            'summary' => 'required|string',
            'language' => 'string',
            'author' => 'required|string',
            'publisher' => 'required|string',
            'publication_date' => 'required|date',
            'dewey_decimal' => 'string'
        ]);
        $book = Books::where('id',$request->id)->with('locations')->firstOrFail();

        return Inertia::render('Admin/Books/Detail', ['book' => $book]);
    }

    // show create book form
    public function create(Request $request)
    {
        return Inertia::render('Admin/Books/New');
    }

    // save the book
    public function save(Request $request)
    {
        //
    }
}
