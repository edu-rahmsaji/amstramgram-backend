<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function readFollowers(Request $request)
    {
        $userId = $request->route('id');
        return Follow::where('follower_id', '=', $userId)->get();
    }

    public function readFollowed(Request $request)
    {
        $userId = $request->route('id');
        return Follow::where('followed_id', '=', $userId)->get();
    }

    public function followerCount(Request $request)
    {
        $userId = $request->route('id');
        return Follow::where('follower_id', '=', $userId)->count();
    }

    public function followedCount(Request $request)
    {
        $userId = $request->route('id');
        return Follow::where('followed_id', '=', $userId)->count();
    }
}
