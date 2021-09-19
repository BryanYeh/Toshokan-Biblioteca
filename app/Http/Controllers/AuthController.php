<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'visitor'
        ]);

        $token = $user->createToken('Visitor Token')->accessToken;

        return response([ 'user' => $user, 'token' => $token]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:255',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $user = User::where('username', $request->username)->first();

        if ($user && in_array($user->user_type, ['visitor', 'patron']) && Hash::check($request->password, $user->password)) {
            $tokenResult = $user->createToken('Login');
            $token_exp_at = $tokenResult->token->expires_at;
            $accessToken = $tokenResult->accessToken;

            if($user->user_type == 'visitor') {
                $user_data = [
                    'first_name' => $user->first_name,
                    'first_name' => $user->last_name,
                    'user_type' => $user->user_type,
                    'username' => $user->username
                ];
            }
            else {
                $user_data = $user;
            }

            return response([
                'user' => $user_data,
                'access_token' => $accessToken,
                'token_expires_at' => $token_exp_at
            ], 200);
        }

        return response()->json([
            'errors' => [
                'The provided credentials do not match our records.'
            ]
        ], 401);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        return response()->json([
            'message' => 'You have been successfully logged out!'
        ], 200);
    }
}
