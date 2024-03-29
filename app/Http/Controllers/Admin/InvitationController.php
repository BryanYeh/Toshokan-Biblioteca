<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class InvitationController extends Controller
{
    // page of invitation acceptance
    public function __invoke(Request $request)
    {
        $invitation = Invitation::where([
            'email' => $request->email,
            'invitation_token' => $request->code
        ])
            ->whereNull('accepted_at')
            ->whereDate('invited_at', '>', Carbon::now()->subDays(30))
            ->first();

        if ($invitation) {
            return response()->json([
                'first_name' => $invitation->first_name,
                'last_name' => $invitation->last_name,
                'email' => $invitation->email,
                'token' => $invitation->invitation_token
            ]);
        } else {
            return response()->json(['error' => 'Invitation Expired']);
        }
    }

    // accept the invitation
    public function accept(Request $request)
    {
        $request->validate([
            'invitation_token' => 'required|string|max:32',
            'username' => 'required|string|max:255',
            'password' => 'required|string|confirmed',
            'email' => 'required|email|unique:users'
        ]);

        $invitation = Invitation::where([
            'email' => $request->email,
            'invitation_token' => $request->invitation_token
        ])
            ->whereNull('accepted_at')
            ->whereDate('invited_at', '>', Carbon::now()->subDays(30))
            ->first();

        if (!$invitation) {
            return response()->json(['error' => 'Invitation Expired']);
        }

        $invitation->accepted_at = Carbon::now();
        $invitation->save();

        User::create(
            [
                'user_type' => $invitation->user_type,
                'username' => $request->username,
                'first_name' => $invitation->first_name,
                'last_name' => $invitation->last_name,
                'email' => $invitation->email,
                'password' => Hash::make($request->password),
            ]
        );

        return response()->json(['success' => 'Invitation Accepted!']);
    }
}
