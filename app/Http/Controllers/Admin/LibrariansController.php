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
        $valid_columns = ['id', 'username', 'email', 'first_name', 'last_name'];
        if (
            $request->has('sortCol') && $request->has('sortOrder')
            && in_array(Str::slug($request->query('sortCol'), '_'), $valid_columns)
        ) {
            $column = Str::slug($request->query('sortCol'), '_');
            $direction = $request->query('sortCol') === 'asc' ? 'ASC' : 'DESC';

            $librarians = User::where('user_type', 'librarian')
                ->select('id', 'first_name', 'last_name', 'username', 'email')
                ->orderBy($column, $direction)->paginate(env('PER_PAGE'))->withQueryString();

            return response()->json($librarians);
        }

        $librarians = User::where('user_type', 'librarian')
            ->select('id', 'first_name', 'last_name', 'username', 'email')
            ->paginate(env('PER_PAGE'));

        return response()->json($librarians);
    }

    // return librarian
    public function show(Request $request)
    {
        $librarian = User::select('id', 'first_name', 'last_name', 'username', 'email')
            ->where('user_type', 'librarian')
            ->where('id', $request->id)
            ->first();

        if (!$librarian) {
            return response()->json(['message' => 'Librarian not found'], 404);
        }

        return response()->json($librarian);
    }

    // update librarian
    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required',
            'email' => 'required|email'
        ]);

        $librarian = User::where('user_type', 'librarian')
                        ->where('id', $request->id)->first();

        if (!$librarian) {
            return response()->json(['message' => 'Subject not found'], 404);
        }

        $librarian->update($request->all());

        return response()->json(['message' => 'Successfully updated librarian.']);
    }

    // delete librarian
    public function destroy(Request $request)
    {
        $librarian = User::where('user_type', 'librarian')
            ->where('id', $request->id)->first();

        if (!$librarian) {
            return response()->json(['message' => 'Librarian not found'], 404);
        }

        $librarian->delete();

        return response()->json(null, 204);
    }

    // send librarian invitation
    public function invite(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users'
        ]);

        $librarian = User::where('email', $request->email)->first();
        if ($librarian) {
            return response()->json(['message' => "$request->first_name $request->last_name is already an existing librarian"], 409);
        }

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

        return response()->json(['message' => "Successfully sent librarian invitation to $request->first_name"]);
    }
}
