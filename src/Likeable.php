<?php

declare(strict_types=1);

namespace Likeable\Likeable;

class Likeable
{
    /**
     * The likes that belong to this object.
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likable');
    }

    /**
     * Check whether the current object is liked by the currently
     * authenticated user.
     */
    public function getLikedAttribute(): bool
    {
        return $this->likes->contains(function ($like) {
            return $like->user_id == auth()->id();
        });
    }

    /**
     * Like this object.
     */
    public function like(): Like
    {
        return $this->likes()->create(['user_id' => auth()->id()]);
    }

    /**
     * Unlike this object.
     */
    public function unlike(): Like
    {
        return tap($this->likes()->where(['user_id' => auth()->id()])
            ->first())
            ->delete();
    }
}
