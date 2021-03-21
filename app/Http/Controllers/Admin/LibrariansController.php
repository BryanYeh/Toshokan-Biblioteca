<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Invitation;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\LibrarianInvitation;

class LibrariansController extends Controller
{
    // list of librarians
    public function __invoke(Request $request)
    {

        // order by column from $request->sort (column name, sorting direction)
        if(isset($request->sort) && count(explode(' ',$request->sort)) == 2){
            $sort = explode(' ',$request->sort);
            $column = Str::slug($sort[0],'_');
            $direction = $sort[1] === 'asc' ? 'ASC' : 'DESC';
            return User::where('user_type', 'librarian')
                            ->select('first_name','last_name','username','uuid')
                            ->orderBy($column, $direction)
                            ->paginate(25)->withQueryString();
        }

        return User::where('user_type', 'librarian')
                        ->select('first_name','last_name','username','uuid')
                        ->paginate(25)->withQueryString();
    }

    // view librarian profile
    public function view(Request $request)
    {
        $librarian = User::where('id',$request->id)->first();
        return $librarian;
    }

    // delete librarian
    public function remove(Request $request)
    {
        User::destroy($request->id);

        return response()->json('Successfully deleted librarian');
    }

    // send librarian invitation
    public function send(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users'
        ]);

        $invitation = Invitation::updateOrCreate(
            ['email' => $request->email],
            [
                'user_type' => 'librarian',
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'invitation_token' => Str::randomAlpha(32),
                'invited_at' => Carbon::now()
            ]
        );

        Mail::to($request->user())->send(new LibrarianInvitation($invitation));

        return response()->json(['message'=> "Successfully invited $request->first_name to be a librarian"]);
    }
}
