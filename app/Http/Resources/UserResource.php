<?php

namespace App\Http\Resources;

use App\Models\Follow;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nickname' => $this->nickname,
            'isPrivate' => $this->is_private,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'biography' => $this->biography,
            'meta' => [
                'postCount' => Post::where('user_id', '=', $this->id)->get()->count(),
                'followerCount' => Follow::where('followed_id', '=', $this->id)->get()->count(),
                'followingCount' => Follow::where('follower_id', '=', $this->id)->get()->count()
            ],
            'joinedOn' => $this->created_at
        ];
    }
}
