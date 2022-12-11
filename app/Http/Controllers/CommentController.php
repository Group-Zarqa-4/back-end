<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //return all comments
    public function getComments($id = null)
    {
        return $id ? Comment::findOrFail($id) : Comment::all();
    }

    // store new comment
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


    //delete comment
    public function deleteComment(Request $request)
    {
        $comment = Comment::findOrFail($request->id);
        $comment->delete();
        return ['status' => 'comment has been deleted successfully'];
    }

    
}
