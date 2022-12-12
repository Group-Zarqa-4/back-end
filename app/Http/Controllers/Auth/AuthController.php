<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            "user" => $user,
            "userId" => $user->id
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
            "user" => Auth::user(),
            "userId" => Auth::user()->id,
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
                "userId" => $user->id
            ]);
        } else {
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "google_id" => $request->google_id,
                "userId" => $user->id,
            ]);
            $token = $user->createToken("auth_token")->plainTextToken;
            return response([
                "status" => "success",
                "message" => "User LoggedIn successfully",
                "token" => $token,
                // "user" => Auth::user(),
                "userId" => Auth::user()->id,
            ]);
        }
    }


    public function update_user(Request $request)
    {
        $user = User::findOrFail($request->id);
        $request->validate([
            "name" => "required",
            "email" => 'unique:users,email,' . $user->id . ',id',
            // "image" => "required",
        ]);
        $imageName = time() . "." . $request->file("image")->getClientOriginalExtension();
        $request->image->move("C:\User-Interface\src\users", $imageName);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $imageName;
        $check =  $user->save();

        if ($check) {
            return response(['results' => 'user updated successfully']);
        } else {
            return ['results' => 'update error'];
        }
    }



    public function update_password(Request $request)
    {

        $request->validate(
            [
                'password_current' => 'required',
                'password_new' => 'required|required_with:password_confirmation|same:password_confirmation',
                'password_confirmation' => 'required'
            ]
        );

        $user = User::findOrFail($request->id);
        // return response(["user" => $user]);
        $check = Hash::check($request->password_current, $user->password);
        if ($check) {
            $user->name = $user->name;
            $user->email = $user->email;
            $user->password = Hash::make($request->password_new);
            $user->save();
            return response([
                "status" => 200,
                "message" => "Password changed successfully"
            ]);
        }
    }
}
