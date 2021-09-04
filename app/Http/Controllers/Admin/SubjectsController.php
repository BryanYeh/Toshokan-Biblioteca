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
        // order by column from $request->sort (column name, sorting direction)
        $valid_columns = ['id', 'name'];
        if (
            $request->has('sortCol') && $request->has('sortOrder')
            && in_array(Str::slug($request->query('sortCol'), '_'), $valid_columns)
        ) {
            $column = Str::slug($request->query('sortCol'), '_');
            $direction = $request->query('sortCol') === 'asc' ? 'ASC' : 'DESC';

            $subjects = Subject::orderBy($column, $direction)->paginate(env('PER_PAGE'))->withQueryString();

            return response()->json($subjects);
        }

        $subjects = Subject::paginate(env('PER_PAGE'));

        return response()->json($subjects);
    }

    // create subject
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|required|unique:subjects',
        ]);

        $subject = new Subject();
        $subject->name = $request->name;
        $subject->save();

        return response()->json(['message' => "Successfully added Subject."]);
    }

    // subjects details
    public function show(Request $request)
    {
        $subject = Subject::where('id', $request->id)->first();

        if (!$subject) {
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
        $subject = Subject::where('uuid', $request->uuid)->first();

        if (!$subject) {
            return response()->json(['message' => 'Subject not found'], 404);
        }

        $subject->update($request->all());

        return response()->json(['message' => 'Successfully updated subject.']);
    }
}
