<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books;
use App\Models\Location;
use App\Models\BookLocation;

class BooksController extends Controller
{
    // list of books
    public function __invoke()
    {
        $books = Books::select('title','edition','isbn','image','id')->paginate(25);
        return $books;
    }

    // view book info with locations
    public function view(Request $request)
    {
        $book = Books::where('id',$request->id)->with('locations')->firstOrFail();
        return $book;
    }

    // show edit book form
    public function edit(Request $request)
    {
        $book = Books::where('books.id',$request->id)->with('locations.library')->firstOrFail();
        $libraries = Location::select(['id','name'])->get();
        return response()->json([
            $libraries, $book
        ]);
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
        $book = Books::where('id',$request->id)->firstOrFail();
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

        foreach($request->locations as $location){
            $bookLocation = null;
            if(isset($location['id']) && !is_null($location['id'])){
                $bookLocation = BookLocation::where('id',$location['id'])->first();
            }
            elseif(!isset($location['id'])
                    && !is_null($location['location_id'])
                    && !is_null($location['barcode'])
                    && !is_null($location['call_number'])
                    && !is_null($location['location'])
                    && !is_null($location['price'])){
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

        $book = Books::where('id',$request->id)->with('locations')->firstOrFail();
        return $book;
    }

    // show create book form
    public function create(Request $request)
    {
        $libraries = Location::select(['id','name'])->get();
        return $libraries;
    }

    // save the book
    public function save(Request $request)
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
        $book = new Books();
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

        foreach($request->locations as $location){
            $bookLocation = null;
            if(isset($location['id']) && !is_null($location['id'])){
                $bookLocation = BookLocation::where('id',$location['id'])->first();
            }
            elseif(!isset($location['id'])
                    && !is_null($location['location_id'])
                    && !is_null($location['barcode'])
                    && !is_null($location['call_number'])
                    && !is_null($location['location'])
                    && !is_null($location['price'])){
                $bookLocation = new BookLocation();
                $bookLocation->book_id = $book->id;
            }

            $bookLocation->location_id = $location['location_id'];
            $bookLocation->barcode = $location['barcode'];
            $bookLocation->call_number = $location['call_number'];
            $bookLocation->location = $location['location'];
            $bookLocation->price = $location['price'];
            $bookLocation->save();
        }

        return redirect()->back()->with('success','Successfully added book');
    }
}
