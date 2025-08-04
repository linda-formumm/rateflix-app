<?php

use App\Services\OmdbService;
use Illuminate\Support\Facades\Http;

test('omdb service can search for movies', function () {
    // Mock HTTP response
    Http::fake([
        'www.omdbapi.com/*' => Http::response([
            'Search' => [
                [
                    'Title' => 'The Matrix',
                    'Year' => '1999',
                    'imdbID' => 'tt0133093',
                    'Type' => 'movie',
                    'Poster' => 'https://example.com/matrix.jpg'
                ]
            ],
            'totalResults' => '1',
            'Response' => 'True'
        ])
    ]);
    
    $omdbService = new OmdbService();
    $results = $omdbService->searchMovies('Matrix');
    
    expect($results)->toBeArray();
    expect($results[0]['Title'])->toBe('The Matrix');
    expect($results[0]['imdbID'])->toBe('tt0133093');
});

test('omdb service handles no results gracefully', function () {
    Http::fake([
        'www.omdbapi.com/*' => Http::response([
            'Response' => 'False',
            'Error' => 'Movie not found!'
        ])
    ]);
    
    $omdbService = new OmdbService();
    $results = $omdbService->searchMovies('NonexistentMovie');
    
    expect($results)->toBe(null);
});

test('omdb service can get movie details', function () {
    Http::fake([
        'www.omdbapi.com/*' => Http::response([
            'Title' => 'The Matrix',
            'Year' => '1999',
            'Rated' => 'R',
            'Released' => '31 Mar 1999',
            'Runtime' => '136 min',
            'Genre' => 'Action, Sci-Fi',
            'Director' => 'Lana Wachowski, Lilly Wachowski',
            'Plot' => 'A computer programmer discovers reality is a simulation.',
            'imdbID' => 'tt0133093',
            'imdbRating' => '8.7',
            'Response' => 'True'
        ])
    ]);
    
    $omdbService = new OmdbService();
    $details = $omdbService->getMovieDetails('tt0133093');
    
    expect($details)->toBeArray();
    expect($details['Title'])->toBe('The Matrix');
    expect($details['Genre'])->toBe('Action, Sci-Fi');
    expect($details['imdbRating'])->toBe('8.7');
});

test('omdb service handles api errors gracefully', function () {
    Http::fake([
        'www.omdbapi.com/*' => Http::response([], 500)
    ]);
    
    $omdbService = new OmdbService();
    $results = $omdbService->searchMovies('Matrix');
    
    expect($results)->toBe(null);
});
