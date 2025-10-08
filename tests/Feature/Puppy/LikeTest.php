<?php

use App\Models\Puppy;
use App\Models\User;

describe('puppies.like', function () {
    test('authenticated user can toggle like on a puppy', function () {
        $this->actingAs($user = User::factory()->create());
        $puppy = Puppy::factory()->create();

        // Like
        $response = $this->patch(route('puppies.like', $puppy));
        $response->assertRedirect();
        expect($puppy->fresh()->likedBy()->whereKey($user->id)->exists())->toBeTrue();

        // Unlike (toggle)
        $response = $this->patch(route('puppies.like', $puppy));
        $response->assertRedirect();
        expect($puppy->fresh()->likedBy()->whereKey($user->id)->exists())->toBeFalse();
    });

    test('guests are redirected to login', function () {
        $puppy = Puppy::factory()->create();

        $response = $this->patch(route('puppies.like', $puppy));
        $response->assertRedirect(route('login'));
    });
});
