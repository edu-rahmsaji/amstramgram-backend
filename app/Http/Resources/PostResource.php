<?php

namespace App\Http\Resources;

use App\Models\PostLike;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = new UserResource(User::where('id', '=', $this->user_id)->first());
        $likes = PostLike::where('post_id', '=', $this->id)->get()->count();

        return [
            'id' => $this->id,
            'user' => [
                'id' => $user->id,
                'nickname' => $user->nickname,
                'firstName' => $user->first_name,
                'lastName' => $user->last_name
            ],
            'text' => $this->text,
            'imagePaths' => $this->image_paths,
            'likes' => $likes,
            'postedAt' => $this->created_at
        ];
    }
}
