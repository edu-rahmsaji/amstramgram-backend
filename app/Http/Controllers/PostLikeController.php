<?php

namespace App\Http\Controllers;

use App\Models\PostLike;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function likedPosts(Request $request)
    {
        $userId = $request->route('id');
        return PostLike::where('user_id', $userId)->get();
    }
}
