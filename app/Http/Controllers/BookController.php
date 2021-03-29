<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;
use Illuminate\Support\Str;

class BookController extends Controller
{
    // list of books
    public function __invoke(Request $request)
    {
        // order by column from $request->sort (column name, sorting direction)
        if(isset($request->sort) && count(explode(' ',$request->sort)) == 2){
            $sort = explode(' ',$request->sort);
            $column = Str::slug($sort[0],'_');
            $direction = $sort[1] === 'asc' ? 'ASC' : 'DESC';

            return response()->json(Books::with(['locations'=> function($query){
                                    $query->withCount('isLent');
                                }])
                                ->orderBy($column, $direction)
                                ->paginate(25)->withQueryString());
        }

        return response()->json(Books::with(['locations'=> function($query){
                                $query->withCount('isLent');
                            }])->paginate(25));
    }
}
