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

    // subjects details
    public function show(Request $request)
    {
        $subject = Subject::where('uuid',$request->uuid)->first();

        if(!$subject){
            return response()->json(['message' => 'Subject not found'], 404);
        }

        return response()->json($subject);
    }

    // update subject
    public function update(Request $request)
    {
        $request->validate([
            'subject' => 'string|required|unique:subjects',
        ]);
        $subject = Subject::where('uuid',$request->uuid)->first();

        if(!$subject){
            return response()->json(['message' => 'Subject not found'], 404);
        }

        $subject->update($request->all());

        return response()->json(['message'=>'Successfully updated subject.']);
    }

    // save subject
    public function save(Request $request)
    {
        $request->validate([
            'subject' => 'string|required|unique:subjects',
        ]);

        $subject = new Subject();
        $subject->subject = $request->subject;
        $subject->uuid = (string) Str::uuid();
        $subject->save();

        return response()->json(['message'=>"Successfully added Subject."]);
    }
}
