<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function viewList()
    {
        $books = Book::paginate(25);
        return view('dashboard.books', ['books' => $books]);
    }

    public function create(Request $request)
    {
        return redirect()->route('books');
    }

    public function store(Request $request)
    {
        return redirect()->route('books');
    }

    public function edit(Request $request)
    {
        return redirect()->route('books');
    }

    public function update(Request $request)
    {
        return redirect()->route('books');
    }
}
