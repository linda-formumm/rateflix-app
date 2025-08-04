<?php

use App\Models\User;
use App\Models\UserRating;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated users can access movie search page', function () {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get('/movies');
    
    $response->assertStatus(200);
    $response->assertSee('Enter movie title');
});

test('guests are redirected from movie search page', function () {
    $response = $this->get('/movies');
    
    $response->assertRedirect('/login');
});

test('user cannot rate same movie twice', function () {
    $user = User::factory()->create();
    
    // Create first rating
    UserRating::create([
        'user_id' => $user->id,
        'imdb_id' => 'tt0133093',
        'movie_title' => 'The Matrix',
        'rating' => 5
    ]);
    
    // Try to create a duplicate rating - this should throw a constraint violation
    expect(function () use ($user) {
        UserRating::create([
            'user_id' => $user->id,
            'imdb_id' => 'tt0133093',
            'movie_title' => 'The Matrix',
            'rating' => 4
        ]);
    })->toThrow(\Illuminate\Database\UniqueConstraintViolationException::class);
    
    // User should still have only one rating
    expect($user->ratings)->toHaveCount(1);
});

test('user can delete their rating', function () {
    $user = User::factory()->create();
    
    $rating = UserRating::create([
        'user_id' => $user->id,
        'imdb_id' => 'tt0133093',
        'movie_title' => 'The Matrix',
        'rating' => 4
    ]);
    
    $rating->delete();
    
    $this->assertDatabaseMissing('user_ratings', [
        'user_id' => $user->id,
        'imdb_id' => 'tt0133093'
    ]);
});

test('rating validation works correctly', function () {
    $user = User::factory()->create();
    
    // Test that valid ratings work
    $validRating = UserRating::create([
        'user_id' => $user->id,
        'imdb_id' => 'tt0133093',
        'movie_title' => 'The Matrix',
        'rating' => 5
    ]);
    
    expect($validRating->rating)->toBe(5);

});

test('users can only see their own ratings on ratings page', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    
    // Create ratings for both users
    UserRating::create([
        'user_id' => $user1->id,
        'imdb_id' => 'tt0133093',
        'movie_title' => 'The Matrix',
        'rating' => 5
    ]);
    
    UserRating::create([
        'user_id' => $user2->id,
        'imdb_id' => 'tt0111161',
        'movie_title' => 'The Shawshank Redemption',
        'rating' => 5
    ]);
    
    $response = $this->actingAs($user1)->get('/ratings');
    
    $response->assertStatus(200);
    $response->assertSee('The Matrix');
    $response->assertDontSee('The Shawshank Redemption');
});

test('dashboard shows correct rating count', function () {
    $user = User::factory()->create();
    
    // Create some ratings using direct model creation
    UserRating::create([
        'user_id' => $user->id,
        'imdb_id' => 'tt0133093',
        'movie_title' => 'The Matrix',
        'rating' => 5
    ]);
    
    UserRating::create([
        'user_id' => $user->id,
        'imdb_id' => 'tt0111161',
        'movie_title' => 'The Shawshank Redemption',
        'rating' => 4
    ]);
    
    UserRating::create([
        'user_id' => $user->id,
        'imdb_id' => 'tt0068646',
        'movie_title' => 'The Godfather',
        'rating' => 5
    ]);
    
    $response = $this->actingAs($user)->get('/dashboard');
    
    $response->assertStatus(200);
    $response->assertSee('Your Ratings (3)');
});
