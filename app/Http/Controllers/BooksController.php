<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;
use Illuminate\Support\Str;

class BooksController extends Controller
{
    // list of books
    public function __invoke(Request $request)
    {
        // order by column from $request->sort (column name, sorting direction)
        $valid_columns = ['id', 'title', 'author', 'publisher', 'publication_date'];

        if (
            $request->has('sortCol') && $request->has('sortOrder')
            && in_array(Str::slug($request->query('sortCol'), '_'), $valid_columns)
        ) {
            $column = Str::slug($request->query('sortCol'), '_');
            $direction = $request->query('sortCol') === 'asc' ? 'ASC' : 'DESC';

            $books = Books::with('subjects')
                        ->with(['locations.copies.lent' => function($query) {
                            $query->select(['id','book_id', 'lend_date']);
                        }])
                        ->orderBy($column, $direction)->paginate(env('PER_PAGE'))->withQueryString();

            return response()->json($books);
        }

        $books = Books::with('subjects')
                    ->with(['locations.copies.lent' => function($query) {
                        $query->select(['id','book_id', 'lend_date']);
                    }])
                    ->paginate(env('PER_PAGE'));

        return response()->json($books);
    }

    public function show(Request $request)
    {
        $slug = Str::slug($request->slug, '_');

        $book = Books::where('slug', $slug)
                    ->with('subjects')
                    ->with(['locations.copies.lent' => function($query) {
                        $query->select(['id','book_id', 'lend_date']);
                    }])
                    ->first();

        if(!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        return $book;
    }

    public function search(Request $request)
    {
        if (!$request->q) {
            return response()->json([]);
        }

        $books = Books::where('title', 'like', "%{$request->q}%")
            ->with(['locations' => function ($query) {
                $query->withCount('isLent');
            }])
            ->paginate(25);

        return response()->json($books);
    }
}
