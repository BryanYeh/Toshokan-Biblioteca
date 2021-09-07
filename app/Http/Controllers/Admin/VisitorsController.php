<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class VisitorsController extends Controller
{
    // list of visitors
    public function __invoke(Request $request)
    {
        // order by column from $request->sort (column name, sorting direction)
        $valid_columns = ['id', 'username', 'email', 'first_name', 'last_name'];
        if (
            $request->has('sortCol') && $request->has('sortOrder')
            && in_array(Str::slug($request->query('sortCol'), '_'), $valid_columns)
        ) {
            $column = Str::slug($request->query('sortCol'), '_');
            $direction = $request->query('sortCol') === 'asc' ? 'ASC' : 'DESC';

            $visitors = User::where('user_type', 'visitor')
                ->orderBy($column, $direction)->paginate(env('PER_PAGE'))->withQueryString();

            return response()->json($visitors);
        }

        $visitors = User::where('user_type', 'visitor')
            ->paginate(env('PER_PAGE'));

        return response()->json($visitors);
    }

    // view visitor profile
    public function show(Request $request)
    {
        $visitor = User::select('id', 'username', 'email', 'first_name', 'last_name')
                        ->where('id', $request->id)
                        ->where('user_type', 'vistor')
                        ->first();

        if (!$visitor) {
            return response()->json(['message' => 'Visitor not found'], 404);
        }

        return response()->json($visitor);
    }

    // upgrade visitor to a patron
    public function upgrade(Request $request)
    {
        $request->validate([
            'card_number' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'dob' => 'required|date',
            'address1' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|max:255'
        ]);

        $visitor = User::where('uuid',$request->uuid)->first();

        if(!$visitor){
            return response()->json(['message' => 'Visitor not found'], 404);
        }

        $data = $request->all();
        $data['user_type'] = 'patron';
        $data['address_confirmed_at'] = Carbon::now();
        $visitor->update($data);

        return response()->json(['message'=>"$request->first_name $request->last_name is now a patron."]);
    }
}
