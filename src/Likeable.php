<?php

declare(strict_types=1);

namespace Kevinb1989\Likeable;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
     * Like this object.
     */
    public function like(): Like
    {
        throw_if($this->liked, new ModelAlreadyLikedException($this));

        return $this->likes()->create(['user_id' => auth()->id()]);
    }

    /**
     * Unlike this object.
     */
    public function unlike(): void
    {
        throw_unless($this->liked, new ModelNotYetLikedException($this));

        $this->likes()->where('user_id', auth()->id())->delete();
    }

    /**
     * Check whether the current object is liked by the currently
     * authenticated user.
     *
     * @return Attribute<bool, never>
     */
    protected function liked(): Attribute
    {
        return Attribute::make(get: function () {
            if ($this->relationLoaded('likes')) {
                return $this->likes->contains(function (Like $like) {
                    return $like->user_id == auth()->id();
                });
            }

            return $this->likes()->where('user_id', auth()->id())->exists();
        });
    }
}
