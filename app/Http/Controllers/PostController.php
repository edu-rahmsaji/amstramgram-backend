<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Returns a list of all the posts stored in the database.
     */
    public function all()
    {
        return Post::all();
    }

    /**
     * Stores an image under public/posts and creates a new post in the database.
     */
    public function create(Request $request)
    {
        $filename = $this->uploadImage($request);

        if (!$filename) {
            return ['status' => false, 'message' => "Unable to upload the file."];
        }

        $postObj = new Post;
        $postObj->creator_id = $request->creator_id;
        $postObj->description = $request->description;
        $postObj->image = $filename;

        if ($postObj->save()) {
            return ['status' => true, 'message' => "Image uploded successfully"];       
        } else {
            return ['status' => false, 'message' => "Error : Image not uploded successfully"];       
        }
    }

    /**
     * From the request object, uploads an image under the `public/posts` directory with a unique name and returns it.
     * @param Request $request The request object
     * @return string|null The unique name of the stored image, or `null` if something went wrong.
     */
    private function uploadImage(Request $request): string|null {
        if ($request->hasFile('image')) {
            $filename = $request->file('image')->getClientOriginalName(); // get the file name
            $getfilenamewitoutext = pathinfo($filename, PATHINFO_FILENAME); // get the file name without extension
            $getfileExtension = $request->file('image')->getClientOriginalExtension(); // get the file extension
            $createnewFileName = time() . '_' . str_replace(' ', '_', $getfilenamewitoutext) . '.' . $getfileExtension; // create new random file name
            $request->file('image')->storeAs('public/posts', $createnewFileName); // store img under public/posts
            return $createnewFileName;
        }

        return null;
    }
}
