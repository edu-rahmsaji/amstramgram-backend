<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = ['followed_id', 'follower_id'];

    /**
     * Get the user that is following.
     */
    public function follower(): BelongsTo
    {
        return $this->belongsTo(User::class, "follower_id", "id");
    }

    /**
     * Get the user that is being followed.
     */
    public function followed(): BelongsTo
    {
        return $this->belongsTo(User::class, "followed_id", "id");
    }
}
