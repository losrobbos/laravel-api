<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signup(Request $req)
    {
        // $rules = User::$rules;
        // $fields = $req->validate($rules);
        $body = $req->only(['name', 'email', 'password']);

        // user already exists? reject!
        $userFound = User::where("email", $body["email"])->first();

        if($userFound) {
            return response("User already exists!", 400);
        }

        // hash password
        $body['password'] = bcrypt($body['password']); 
        $userNew = User::create($body);

        $tokenSecret = env('TOKEN_SECRET');
        $token = $userNew->createToken($tokenSecret)->plainTextToken;

        $response = [
            "user" => $userNew,
            "token" => $token
        ];

        return $response;
    }

    public function login(Request $req)
    {
        $creds = $req->only(['email', 'password']);

        $userFound = Auth::once($creds);

        if(!$userFound) {
            return response([
                'message' => "User not found"
            ], 400);
        }

        $user = $req->user();
        $tokenSecret = env('TOKEN_SECRET');
        $token = $user->createToken($tokenSecret)->plainTextToken;

        $response = [
            "user" => $user,
            "token" => $token
        ];

        return $response;
    }

    public function logout(Request $req)
    {
        // clear tokens associated with current user in database
        $req->user()->tokens()->delete();
        return response([
            "message" => "Logged out"
        ]);
    }

}
