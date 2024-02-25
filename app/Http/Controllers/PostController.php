<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\{Post, PostLike, User};
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Returns a list of all the posts stored in the database.
     */
    public function readAll()
    {
        try {
            $data = PostResource::collection(Post::all());
            return ["success" => true, "data" => $data, "message" => "All posts read successfully"];
        } catch (Exception $err) {
            error_log($err);
            return ["success" => false, "data" => null, "message" => "An error occurred whilst reading all the posts"];
        }
    }

    /**
     * Returns all the user's posts via it's id.
     * @param User $user The user whose posts to read
     */
    public function readAllByUser(User $user) {
        try {
            $data = PostResource::collection(Post::where('user_id', '=', $user->id)->get());
            return ["success" => true, "data" => $data, "message" => "User's posts read successfully"];
        } catch (Exception $err) {
            error_log($err);
            return ["success" => false, "data" => null, "message" => "An error occurred whilst reading the user's posts"];
        }
    }

    /**
     * Returns a post via it's id.
     * @param Post $post The post to read
     */
    public function read(Post $post) {
        try {
            $data = new PostResource($post);
            return ["success" => true, "data" => $data, "message" => "Post read successfully"];
        } catch (Exception $err) {
            error_log($err);
            return ["success" => false, "data" => null, "message" => "An error occurred whilst reading the post"];
        }
    }

    public function likers(Request $request)
    {
        $postId = $request->route('id');
        $userIds = PostLike::where('post_id','=', $postId)->get()->pluck('user_id');
        return User::find($userIds);
    }

    /**
     * Stores an image under public/posts and creates a new post in the database.
     */
    public function create(Request $request)
    {
        /* $filename = $this->uploadImage($request);

        if (!$filename) {
            return ['success' => false, 'message' => "Unable to upload the file."];
        } */

        $postObj = new Post;
        $postObj->user_id = $request->userId;
        $postObj->text = $request->text;
        $postObj->image_paths = "[]"/* json_encode(["storage/posts/$filename"]) */;

        if ($postObj->save()) {
            return ['success' => true, 'message' => "Post created successfully"];       
        } else {
            return ['success' => false, 'message' => "Error : post not created"];       
        }
    }

    /**
     * From the request object, uploads an image under the `public/posts` directory with a unique name and returns it.
     * @param Request $request The request object
     * @return string|null The unique name of the stored image, or `null` if something went wrong.
     */
    private function uploadImage(Request $request): string|null {
        // Uploading multiple images : https://stackoverflow.com/questions/42643265/how-to-upload-multiple-image-in-laravel

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

    /**
     * Updates a post via it's id with the given data.
     * @param Post $post The post to update
     */
    public function update(Request $request, int $id) {
        try {
            $post = Post::find($id);
            $post->text = $request->text;
            if ($post->save()) {
                return ["success" => true, "message" => "Post updated successfully"];
            } else {
                return ["success" => false, "message" => "Post updated failed"];
            }
        } catch (Exception $err) {
            error_log($err);
            return ["success" => false, "message" => "An error occurred whilst updating a post"];
        }
    }

    /**
     * Deletes a post via it's id.
     * @param Post $post The post to delete
     */
    public function delete(Post $post) {
        try {
            Post::where("id", "=", $post->id)->delete();
            return ["success" => true, "message" => "Post deleted successfully"];
        } catch (Exception $err) {
            error_log($err);
            return ["success" => false, "message" => "An error occurred whilst deleting a post"];
        }
    }
}
