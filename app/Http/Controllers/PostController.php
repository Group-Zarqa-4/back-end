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
                $record = [
                    'post' => $post,
                    'user' => $post->user,
                    'comments' => $post->comments
                ];

                $data = collect($data)->push($record);
            }
            return response()->json($data);
        }
    }
}
