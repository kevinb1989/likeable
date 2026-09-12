<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Kevinb1989\Likeable\Like;
use Kevinb1989\Likeable\ModelAlreadyLikedException;
use Kevinb1989\Likeable\ModelNotYetLikedException;
use Workbench\App\Models\Post;
use Workbench\App\Models\User;

uses(RefreshDatabase::class);

it('likes a model on behalf of the authenticated user', function () {
    $user = User::factory()->create();
    $post = Post::create();

    $this->actingAs($user);

    $like = $post->like();

    expect($like)->toBeInstanceOf(Like::class)
        ->and($like->user_id)->toBe($user->id)
        ->and($post->likes)->toHaveCount(1)
        ->and($post->liked)->toBeTrue();
});

it('cannot like a model twice on behalf of the authenticated user', function () {
    $user = User::factory()->create();
    $post = Post::create();

    $this->actingAs($user);

    $post->like();
    $post->like();
})->throws(ModelAlreadyLikedException::class, 'Model #1 has already been liked by the authenticated user.');

it('unlikes a model on behalf of the authenticated user', function () {
    $user = User::factory()->create();
    $post = Post::create();

    $this->actingAs($user);

    $post->like();
    $post->unlike();

    expect($post->fresh()->likes)->toHaveCount(0)
        ->and($post->fresh()->liked)->toBeFalse();
});

it('cannot unlike a model which is not yet liked on behalf of the authenticated user', function () {
    $user = User::factory()->create();
    $post = Post::create();

    $this->actingAs($user);

    $post->unlike();
})->throws(ModelNotYetLikedException::class, 'Model #1 has not been liked by the authenticated user.');

it('reports liked as false for a guest', function () {
    $post = Post::create();

    expect($post->liked)->toBeFalse();
});

it('reads liked from an already eager loaded likes relation without querying', function () {
    $user = User::factory()->create();
    $post = Post::create();

    $this->actingAs($user);
    $post->like();

    $post = Post::with('likes')->findOrFail($post->id);

    DB::enableQueryLog();
    $liked = $post->liked;
    DB::disableQueryLog();

    expect($liked)->toBeTrue()
        ->and(DB::getQueryLog())->toBeEmpty();
});
