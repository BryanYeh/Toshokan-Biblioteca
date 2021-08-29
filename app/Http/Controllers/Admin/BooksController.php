<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books;
use App\Models\Location;
use App\Models\BookLocation;
use Illuminate\Support\Str;

class BooksController extends Controller
{
    // list of books
    public function __invoke(Request $request)
    {
        // order by column from $request->sort (column name, sorting direction)
        $valid_columns = [
            'id', 'title', 'isbn', 'edition',
            'summary', 'language', 'image', 'author',
            'publisher', 'publication_date', 'dewey_decimal'
        ];
        if (
            $request->has('sortCol') && $request->has('sortOrder')
            && in_array(Str::slug($request->query('sortCol'), '_'), $valid_columns)
        ) {
            $column = Str::slug($request->query('sortCol'), '_');
            $direction = $request->query('sortCol') === 'asc' ? 'ASC' : 'DESC';

            $books = Books::orderBy($column, $direction)->paginate(env('PER_PAGE'));

            return response()->json($books);
        }

        $books = Books::paginate(env('PER_PAGE'));

        return response()->json($books);
    }

    // book info
    public function show(Request $request)
    {
        $book = Books::where('id', $request->id)
            ->with('copies.lends.patron')
            ->with(['copies' => function ($query) {
                $query->with('location');
            }])

            ->with('subjects')->first();

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json($book);
    }

    // update book
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'isbn' => 'required|string',
            'edition' => 'string|nullable',
            'summary' => 'required|string',
            'language' => 'string|nullable',
            'author' => 'required|string',
            'publisher' => 'required|string',
            'publication_date' => 'required|date',
            'dewey_decimal' => 'string|nullable',
            'locations.*.id' => 'integer|nullable',
            'locations.*.location_id' => 'exists:locations,id|nullable',
            'locations.*.barcode' => 'string|nullable',
            'locations.*.call_number' => 'string|nullable',
            'locations.*.location' => 'string|nullable',
            'locations.*.price' => 'regex:/^\d+(\.\d{1,2})?$/|nullable'
        ]);
        $book = Books::where('id', $request->id)->firstOrFail();
        $book->title = $request->title;
        $book->isbn = $request->isbn;
        $book->edition = $request->edition;
        $book->summary = $request->summary;
        $book->language = $request->language;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->publication_date = $request->publication_date;
        $book->dewey_decimal = $request->dewey_decimal;
        $book->save();

        foreach ($request->locations as $location) {
            $bookLocation = null;
            if (isset($location['id']) && !is_null($location['id'])) {
                $bookLocation = BookLocation::where('id', $location['id'])->first();
            } elseif (
                !isset($location['id'])
                && !is_null($location['location_id'])
                && !is_null($location['barcode'])
                && !is_null($location['call_number'])
                && !is_null($location['location'])
                && !is_null($location['price'])
            ) {
                $bookLocation = new BookLocation();
                $bookLocation->book_id = $request->id;
            }

            $bookLocation->location_id = $location['location_id'];
            $bookLocation->barcode = $location['barcode'];
            $bookLocation->call_number = $location['call_number'];
            $bookLocation->location = $location['location'];
            $bookLocation->price = $location['price'];
            $bookLocation->save();
        }

        $book = Books::where('id', $request->id)->with('locations')->firstOrFail();
        return $book;
    }

    // create book
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:books',
            'isbn' => 'required|unique:books',
            'edition' => 'nullable',
            'summary' => 'required',
            'language' => 'nullable',
            'image' => 'mimes:jpg,bmp,png|max:10240',
            'author' => 'required',
            'publisher' => 'required',
            'publication_date' => 'required|date',
            'dewey_decimal' => 'nullable',
            'locations.*.location_id' => 'exists:locations,id|required',
            'locations.*.barcode' => 'required_if:locations.*.location_id,null',
            'locations.*.call_number' => 'required_if:locations.*.location_id,null',
            'locations.*.section' => 'required_if:locations.*.location_id,null',
            'locations.*.price' => 'regex:/^\d+(\.\d{1,2})?$/|required_if:locations.*.location_id,null',
            'subjects.*.subject_id' => 'exists:subjects,id|required',
        ]);

        $book = new Books();
        $book->title = $request->title;
        $book->slug = Str::slug($request->slug, '_');
        $book->isbn = $request->isbn;
        $book->edition = $request->edition;
        $book->summary = $request->summary;
        $book->language = $request->language;
        $book->image = $request->file('image')->store('images/covers', 'public');
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->publication_date = $request->publication_date;
        $book->dewey_decimal = $request->dewey_decimal;
        $book->save();

        foreach ($request->locations as $location) {
            $book
                ->copies()
                ->attach(
                    $location['location_id'],
                    [
                        'barcode' => $location['barcode'],
                        'call_number' => $location['call_number'],
                        'section' => $location['section'],
                        'price' => $location['price']
                    ]
                );
        }

        $book->subjects()->sync($request->subjects);

        return response()->json(['message' => 'Successfully created book!']);
    }
}
