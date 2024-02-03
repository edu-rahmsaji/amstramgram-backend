<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostLike extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'user_id'];
    public $timestamps = false;

    /**
     * Get the liked post.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the user that liked the post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
