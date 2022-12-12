<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StoryController extends Controller
{
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


    //delete story
    public function deleteStory( $id)
    {
        $story = Story::findOrFail($id);
        $story->delete();
        return ['status' => 'story has been deleted successfully'];
    }
}
