<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signup(Request $req)
    {
        // $rules = User::$rules;
        // $fields = $req->validate($rules);
        $body = $req->all();

        // hash password
        $body['password'] = bcrypt($body['password']); 
        $userNew = User::create($body);

        $token = $userNew->createToken('holySecret')->plainTextToken;

        $response = [
            "user" => $userNew,
            "token" => $token
        ];

        return $response;
    }

    public function login(Request $req)
    {
        $body = $req->all();

        // hash password
        $userFound = User::where("email", $body["email"])->first();
        // $userFound->makeVisible("password");

        // not found? => reject
        if(!$userFound) {
            return response([
                'message' => "User not found"
            ], 400);
        }
        // pws dont match? => reject
        if(!Hash::check($body["password"], $userFound->password)) {
            return response([
                'message' => "Wrong creds"
            ], 400);
        }

        $token = $userFound->createToken('holySecret')->plainTextToken;

        $response = [
            "user" => $userFound,
            "token" => $token
        ];

        return $response;
    }

    public function logout(Request $req)
    {
        // clear tokens associated with current user in database
        $req->user()->tokens()->delete();
        return "Logged out";
        // auth()->user()->tokens()->delete();
    }

}
