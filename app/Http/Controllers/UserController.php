<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //return all users
    public function getUsers($id = null)
    {
        return $id ? User::findOrFail($id) : User::all();
    }


    //store new user
    public function storeUser(Request $request)
    {
        $formFields = $request->validate(
            [
                'name' => ['required', 'min:3'],
                'email' => ['required', 'email', Rule::unique('users', 'email')],
                'password' => 'required|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
            ],
            [
                'password.regex' => 'The password should have minimum eight characters,
            at least one letter, one number and one special character'
            ]
        );



        // Hash Password
        $formFields['password'] = Hash::make($formFields['password']);

        // Create user
        $user = new User();
        $user->name = ucfirst(strtolower($formFields['name']));
        $user->email = strtolower($formFields['email']);
        $user->password = $formFields['password'];
        $check =  $user->save();

        if ($check) {
            return ['results' => 'user added successfully'];
        } else {
            return ['results' => 'unknown error  occured '];
        }
        // Login
        // auth()->login($user);

    }


    // update user
    public function updateUser(Request $request,$id)
    {
        $user = User::findOrFail($id);
        $user->name = ucfirst(strtolower($request['name']));
        $user->email = strtolower($request['email']);
        // $user->password = Hash::make($request['password']);
        $user->role = $request['role'];
        // $user->is_premium = $request['is_premium'];
        $check =  $user->save();

        if ($check) {
            return ['results' => 'user updated successfully'];
        } else {
            return ['results' => 'update error'];
        }
    }


    //delete user
    public function deleteUser( $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return ['status' => 'user has been deleted successfully'];
    }
}
