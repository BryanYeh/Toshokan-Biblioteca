<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books;
use App\Models\BookLocation;
use Illuminate\Support\Facades\Storage;
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

            $books = Books::orderBy($column, $direction)->paginate(env('PER_PAGE'))->withQueryString();

            return response()->json($books);
        }

        $books = Books::paginate(env('PER_PAGE'));

        return response()->json($books);
    }

    // book info
    public function show(Request $request)
    {
        $book = Books::where('id', $request->id)
            ->with('copies.location')
            ->with('copies.lends.patron')

            ->with('subjects')->first();

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json($book);
    }

    // update book
    // method: post, field: _method=PUT
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' => 'required',
            'isbn' => 'required',
            'edition' => 'nullable',
            'summary' => 'required',
            'language' => 'nullable',
            'image' => 'nullable|mimes:jpg,bmp,png|max:10240',
            'author' => 'required',
            'publisher' => 'required',
            'publication_date' => 'required|date',
            'dewey_decimal' => 'nullable',
            'locations.*.id' => 'nullable',
            'locations.*.location_id' => 'exists:locations,id|required',
            'locations.*.barcode' => 'required_if:locations.*.location_id,null',
            'locations.*.call_number' => 'required_if:locations.*.location_id,null',
            'locations.*.section' => 'required_if:locations.*.location_id,null',
            'locations.*.price' => 'regex:/^\d+(\.\d{1,2})?$/|required_if:locations.*.location_id,null',
            'subjects.*.subject_id' => 'exists:subjects,id|required',
        ]);

        $book = Books::where('id', $request->id)->firstOrFail();
        $book->title = $request->title;
        $book->slug = Str::slug($request->slug, '_');
        $book->isbn = $request->isbn;
        $book->edition = $request->edition;
        $book->summary = $request->summary;
        $book->language = $request->language;

        $old_image = ''; // save old image to delete AFTER updating book info
        if($request->hasFile('image')) {
            $old_image = $book->image;
            $book->image = $request->file('image')->store('images/covers', 'public');
        }

        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->publication_date = $request->publication_date;
        $book->dewey_decimal = $request->dewey_decimal;
        $book->save();

        // delete old book image
        if($old_image != '') {
            Storage::disk('public')->delete($old_image);
        }

        foreach ($request->locations as $location) {
            $copy = BookLocation::where('id', $location['id'])->first();
            if($copy) {
                $copy->location_id = $location['location_id'];
                $copy->barcode = $location['barcode'];
                $copy->call_number = $location['call_number'];
                $copy->section = $location['section'];
                $copy->price = $location['price'];
                $copy->save();
            }
            else {
                $book
                    ->locations()
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
        }

        $book->subjects()->sync($request->subjects);

        return response()->json(['message' => 'Successfully updated book!']);
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
                ->locations()
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

        return response()->json(['message' => 'Successfully created book!', 'id' => $book->id ], 201);
    }

    // soft delete book
    public function destroy(Request $request)
    {
        $book = Books::find($request->id);
        $book->delete();

        return response()->json(null, 204);
    }
}
