<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Subject;

class SubjectsController extends Controller
{
    // list of subjects
    public function __invoke(Request $request)
    {
        // order by column from $request->sort (column name, sorting direction) (?sort=subject+asc)
        if(isset($request->sort) && count(explode(' ',$request->sort)) == 2){
            $sort = explode(' ',$request->sort);
            $column = Str::slug($sort[0],'_');
            $direction = $sort[1] === 'asc' ? 'ASC' : 'DESC';

            return response()->json(Subject::orderBy($column, $direction)
                            ->paginate(25)->withQueryString());
        }

        return response()->json(Subject::paginate(25)->withQueryString());
    }
}
