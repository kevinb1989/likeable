<?php

declare(strict_types=1);

namespace Kevinb1989\Likeable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin Model
 */
trait Likeable
{
    /**
     * The likes that belong to this object.
     *
     * @return MorphMany<Like, $this>
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
        if ($this->relationLoaded('likes')) {
            return $this->likes->contains(function (Like $like) {
                return $like->user_id == auth()->id();
            });
        }

        return $this->likes()->where('user_id', auth()->id())->exists();
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
    public function unlike(): void
    {
        $this->likes()->where('user_id', auth()->id())->delete();
    }
}
