<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Kevinb1989\Likeable\Like;
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

it('unlikes a model on behalf of the authenticated user', function () {
    $user = User::factory()->create();
    $post = Post::create();

    $this->actingAs($user);

    $post->like();
    $post->unlike();

    expect($post->fresh()->likes)->toHaveCount(0)
        ->and($post->fresh()->liked)->toBeFalse();
});

it('reports liked as false for a guest', function () {
    $post = Post::create();

    expect($post->liked)->toBeFalse();
});
