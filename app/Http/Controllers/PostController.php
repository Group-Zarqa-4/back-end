<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //get post / posts

    public function getPosts($id = null)
    {
        if ($id) {
            $data = [
                'post' => Post::findOrFail($id),
                'user' => Post::findOrFail($id)->user,
                'comments' => Post::findOrFail($id)->comments
            ];
            return response()->json($data);
        } else {
            $data = [];
            foreach (Post::all() as $post) {
                $comments = [];
                foreach ($post->comments as $comment) {
                    $record = [
                        'content' => $comment->content,
                        'date' => $comment->created_at,
                        'comment_by' => $comment->user,
                    ];
                    array_push($comments, $record);
                }

                $record =
                    ['post' => [
                        'content' => $post->content,
                        'date' => $post->created_at,
                        'user' => $post->user,
                        'id' => $post->id,
                        'comments' => $comments
                    ]];
                array_push($data, $record);
            }
            return response()->json($data);
        }
    }

    // store new post
    public function storePost(Request $request)
    {
        $post = new Post;
        $post->content = $request->content;
        $post->user_id = $request->user_id;
        $check = $post->save();

        if ($check) {
            return ['results' => 'post added successfully'];
        } else {
            return ['results' => 'unknown error  occured '];
        }
    }

    //update post

    public function updatePost(Request $request)
    {
        $post = Post::findOrFail($request->id);
        $post->content = $request->content;
        $post->user_id = $request->user_id;
        $check = $post->save();

        if ($check) {
            return ['results' => 'post updated successfully'];
        } else {
            return ['results' => 'unknown error  occured '];
        }
    }

    //delete post
    public function deletePost($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return ['status' => 'post has been deleted successfully'];
    }
}
