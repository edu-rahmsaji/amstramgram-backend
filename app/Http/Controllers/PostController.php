<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PostController extends Controller
{

    /**
     * Stores an image under public/posts and adds a new post in the database.
     */
    public function add(Request $request) {
        $filename = $this->uploadImage($request);

        if (!$filename) {
            return ['status' => false, 'message' => "Unable to upload the file."];
        }

        $postObj = new Post;
        $postObj->user_id = $request->user_id;
        $postObj->description = $request->description;
        $postObj->image = $filename;
        $postObj->created_at = Carbon::now()->toDate();

        if ($postObj->save()) { // save file in databse
            return ['status' => true, 'message' => "Image uploded successfully"];       
        } else {
            return ['status' => false, 'message' => "Error : Image not uploded successfully"];       
        }
    }

    public function uploadImage(Request $req): string|null {
        if ($req->hasFile('image')) {
            $filename = $req->file('image')->getClientOriginalName(); // get the file name
            $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME); // get the file name without extension
            $getfileExtension = $req->file('image')->getClientOriginalExtension(); // get the file extension
            $createnewFileName = time().'_'.str_replace(' ','_', $getfilenamewitoutext).'.'.$getfileExtension; // create new random file name
            $req->file('image')->storeAs('public/posts', $createnewFileName); // store img under public/posts
            return $createnewFileName;
        }

        return null;
    }
}
