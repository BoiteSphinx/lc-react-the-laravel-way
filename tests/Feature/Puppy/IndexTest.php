<?php

use App\Models\Puppy;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

describe('puppy index', function () {
    test('guests can see home page with puppies', function () {
        Puppy::factory()->count(3)->create();

        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertInertia(fn (Assert $page) =>
                $page->component('puppies/index')
                    ->has('puppies.data', 3)
                    ->has('likedPuppies', 0)
                    ->has('filters')
            );
    });

    test('authenticated users see their liked puppies', function () {
        $user = User::factory()->create();
        $puppies = Puppy::factory()->count(3)->create();

        // User likes 2 puppies
        $user->likedPuppies()->attach($puppies->take(2)->pluck('id'));

        $this->actingAs($user);

        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertInertia(fn ($page) =>
                $page->component('puppies/index')
                    ->has('puppies.data', 3)
                    ->has('likedPuppies', 2)
            );
    });

    test('can search puppies by name', function () {
        Puppy::factory()->create(['name' => 'Rex']);
        Puppy::factory()->create(['name' => 'Buddy']);
        Puppy::factory()->create(['name' => 'Max']);

        $response = $this->get(route('home', ['search' => 'Rex']));

        $response->assertOk()
            ->assertInertia(fn (Assert $page) =>
                $page->component('puppies/index')
                    ->has('puppies.data', 1)
                    ->where('puppies.data.0.name', 'Rex')
                    ->where('filters.search', 'Rex')
            );
    });

    test('can search puppies by trait', function () {
        Puppy::factory()->create(['trait' => 'Playful']);
        Puppy::factory()->create(['trait' => 'Sleepy']);
        Puppy::factory()->create(['trait' => 'Brave']);

        $response = $this->get(route('home', ['search' => 'Playful']));

        $response->assertOk()
            ->assertInertia(fn (Assert $page) =>
                $page->component('puppies/index')
                    ->has('puppies.data', 1)
                    ->where('puppies.data.0.trait', 'Playful')
            );
    });

    test('search returns empty when no matches', function () {
        Puppy::factory()->create(['name' => 'Rex']);

        $response = $this->get(route('home', ['search' => 'NonExistent']));

        $response->assertOk()
            ->assertInertia(fn (Assert $page) =>
                $page->component('puppies/index')
                    ->has('puppies.data', 0)
            );
    });

    test('puppies are ordered by latest first', function () {
        $oldPuppy = Puppy::factory()->create(['created_at' => now()->subDay()]);
        $newPuppy = Puppy::factory()->create(['created_at' => now()]);

        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertInertia(fn (Assert $page) =>
                $page->component('puppies/index')
                    ->where('puppies.data.0.id', $newPuppy->id)
                    ->where('puppies.data.1.id', $oldPuppy->id)
            );
    });

    test('puppies include user and likedBy relationships', function () {
        $user = User::factory()->create();
        $puppy = Puppy::factory()->create(['user_id' => $user->id]);

        // Another user likes this puppy
        $liker = User::factory()->create();
        $puppy->likedBy()->attach($liker->id);

        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertInertia(fn (Assert $page) =>
                $page->component('puppies/index')
                    ->has('puppies.data.0.user')
                    ->has('puppies.data.0.likedBy')
            );
    });

    test('pagination works with search parameters', function () {
        Puppy::factory()->count(15)->create(['name' => 'TestPuppy']);

        $response = $this->get(route('home', ['search' => 'TestPuppy', 'page' => 2]));

        $response->assertOk()
            ->assertInertia(fn (Assert $page) =>
                $page->component('puppies/index')
                    ->has('puppies.data')
                    ->where('filters.search', 'TestPuppy')
            );
    });
});
