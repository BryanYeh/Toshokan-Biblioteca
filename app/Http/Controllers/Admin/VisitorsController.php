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
        if(isset($request->sort) && count(explode(' ',$request->sort)) == 2){
            $sort = explode(' ',$request->sort);
            $column = Str::slug($sort[0],'_');
            $direction = $sort[1] === 'asc' ? 'ASC' : 'DESC';

            return response()->json(User::where('user_type', 'patron')
                            ->select('first_name','last_name','email','uuid')
                            ->orderBy($column, $direction)
                            ->paginate(25)->withQueryString());
        }

        return response()->json(User::where('user_type', 'patron')
                        ->select('first_name','last_name','email','uuid')
                        ->paginate(25)->withQueryString());
    }

    // view visitor profile
    public function show(Request $request)
    {
        $visitor = User::where('uuid',$request->uuid)->first();

        if(!$visitor){
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
