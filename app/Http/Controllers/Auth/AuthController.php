<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:6|confirmed",
        ]);
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);
        $token = $user->createToken("auth_token")->plainTextToken;
        return response()->json([
            "status" => "success",
            "message" => "User registered successfully",
            "token" => $token,
            "user" => $user
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required",
            "password" => "required|min:6",
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            $user = User::where("email", $request->email)->first();
        $token = $user->createToken("auth_token")->plainTextToken;
        return response([
            "status" => "success",
            "message" => "User LoggedIn successfully",
            "token" => $token,
            "user" => Auth::user()
        ]);
    }


    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        // $request->user()->currentAccessToken()->delete();
        // $request->user()->tokens()->delete();
        return response([
            "status" => "200",
            "message" => "User logged out successfully"
        ]);
    }


    public function login_google(Request $request)
    {
        $user = User::where("email", "=", $request->email)->first();
        if ($user) {
            $token = $user->createToken("auth_token")->plainTextToken;
            return response([
                "status" => "success",
                "message" => "User LoggedIn successfully",
                "token" => $token,
                "user" => $user,
                "email" => $request->email
            ]);
        } else {
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "google_id" => $request->google_id
            ]);
            $token = $user->createToken("auth_token")->plainTextToken;
            return response([
                "status" => "success",
                "message" => "User LoggedIn successfully",
                "token" => $token,
                "user" => Auth::user()
            ]);
        }
    }
}
