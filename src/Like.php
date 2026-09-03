<?php

declare(strict_types=1);

namespace Likeable\Likeable;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property string $likable_type
 * @property int $likable_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['user_id'])]
class Like extends Model
{
    /**
     * Get the model that was liked.
     *
     * @return MorphTo<Model, $this>
     */
    public function likable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user that made the like.
     *
     * @return BelongsTo<Model, $this>
     */
    public function user(): BelongsTo
    {
        /** @var class-string<Model> $userModel */
        $userModel = config('auth.providers.users.model');

        return $this->belongsTo($userModel);
    }
}
