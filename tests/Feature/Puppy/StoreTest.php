<?php

use App\Models\Puppy;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

describe('puppies.store', function () {
    test('authenticated user can create a puppy with image', function () {
        Storage::fake('public');

        $this->actingAs($user = User::factory()->create());

        $image = UploadedFile::fake()->image('puppy.jpg', 600, 400);

        $response = $this->post(route('puppies.store'), [
            'name' => 'Rex',
            'trait' => 'Playful',
            'image' => $image,
        ]);

        $response->assertRedirect(route('home', ['page' => 1]));

        $this->assertDatabaseHas('puppies', [
            'name' => 'Rex',
            'trait' => 'Playful',
            'user_id' => $user->id,
        ]);
    });

    test('guests cannot create a puppy', function () {
        $response = $this->post(route('puppies.store'), []);

        $response->assertRedirect(route('login'));
    });

    test('validation errors when required fields missing', function () {
        $this->actingAs(User::factory()->create());

        $response = $this->from(route('home'))->post(route('puppies.store'), [
            // Missing name, trait, and image
        ]);

        $response->assertSessionHasErrors(['name', 'trait', 'image']);
    });
});
