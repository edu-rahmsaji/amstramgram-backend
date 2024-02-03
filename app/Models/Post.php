<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'text', 'image_paths'];

    protected $casts = [
        'image_paths' => 'array'
    ];

    /**
     * Get the user that created this post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(PostLike::class);
    }
}
