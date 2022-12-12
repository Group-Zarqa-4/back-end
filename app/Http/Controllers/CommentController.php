<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    //return all comments
    public function getComments($id = null)
    {
        if ($id) {
            // return $id ? DB::table('comments')
            //     ->join('users', 'users.id', '=', 'comments.user_id')
            //     ->join('posts', 'posts.id', '=', 'comments.post_id')
            //     ->where('posts.id', $id)
            //     ->get() : Comment::all();
            $comments = Post::findOrFail($id)->comments;
            // $users = Comment::all();
            $comments = Comment::all();
            $usersComents = [];
            foreach ($comments as $comment) {
                $usersComents[] = $comment->user;
            }
            return ([
                "comments" => $comments,
                // "users" => $usersComents
            ]);
        } else {
            return Comment::all();
        }
    }

    // store new comment
    public function storeComment(Request $request)
    {
        $comment = new Comment;
        $comment->user_id = $request->user_id;
        $comment->post_id = $request->post_id;
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
    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return ['status' => 'comment has been deleted successfully'];
    }
}
