<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Story;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{

    // ============ get methods ============
    //return all users
    public function getUsers($id = null)
    {
        return $id ? User::findOrFail($id) : User::all();
    }

    //return all stories
    public function getStories($id = null)
    {
        if ($id) {
            $data = [
                'story' => Story::findOrFail($id),
                'comments' => Story::findOrFail($id)->comments,
            ];
        } else {
            $data = [
                'stories' => Story::all(),
            ];
        }
        return response()->json($data);
    }

    //return all comments
    public function getComments($id = null)
    {
        return $id ? Comment::findOrFail($id) : Comment::all();
    }

    // ============ post methods ============

    //store new user
    public function storeUser(Request $request)
    {
        $formFields = $request->validate(
            [
                'name' => ['required', 'min:3'],
                'email' => ['required', 'email', Rule::unique('users', 'email')],
                'password' => 'required|confirmed|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
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

    // store new story

    public function storeStory(Request $request)
    {

        $story = new Story;
        $story->id = $request->id;
        $story->title = $request->storyName;
        $story->author = $request->author;
        $story->pages = $request->pages;
        $story->backgroundImage = $request->backgroundImage;
        $check = $story->save();

        if ($check) {
            return ['results' => 'story added successfully'];
        } else {
            return ['results' => 'unknown error  occured '];
        }
    }

    public function storeComment(Request $request)
    {
        $comment = new Comment;
        $comment->id = $request->id;
        $comment->user_id = $request->user_id;
        $comment->story_id = $request->story_id;
        $comment->content = $request->content;
        $check = $comment->save();

        if ($check) {
            return ['results' => 'comment added successfully'];
        } else {
            return ['results' => 'unknown error  occured '];
        }
    }

    // update user
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = ucfirst(strtolower($request['name']));
        $user->email = strtolower($request['email']);
        $user->role = $request['role'];
        $user->is_premium = $request['is_premium'];
        $check =  $user->save();

        if ($check) {
            return ['results' => 'user updated successfully'];
        } else {
            return ['results' => 'update error'];
        }
    }
    // update story
    public function updateStory(Request $request)
    {
        $story = Story::findOrFail($request->id);
        $story->title = $request['title'];
        $story->author = strtolower($request['author']);
        $story->backgroundImage = Hash::make($request['backgroundImage']);
        $story->pages = $request['pages'];
        $story->is_premium = $request['is_premium'];
        $check =  $story->save();

        if ($check) {
            return ['results' => 'story updated successfully'];
        } else {
            return ['results' => 'update error'];
        }
    }

    //update comment
    public function updateComment(Request $request)
    {
        $comment = Comment::findOrFail($request->id);
        $comment->content = $request->content;
        $check =  $comment->save();

        if ($check) {
            return ['results' => 'comment updated successfully'];
        } else {
            return ['results' => 'update error'];
        }
    }


    //delete user
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return ['status' => 'user has been deleted successfully'];
    }


    //delete story
    public function deleteStory(Request $request)
    {
        $story = Story::findOrFail($request->id);
        $story->delete();
        return ['status' => 'story has been deleted successfully'];
    }


    //delete comment
    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return ['status' => 'comment has been deleted successfully'];
    }
}
