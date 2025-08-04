<?php

namespace App\Services;

use App\Models\UserRating;
use Illuminate\Support\Collection;

class UserRatingService
{
    private OmdbService $omdbService;

    public function __construct(OmdbService $omdbService)
    {
        $this->omdbService = $omdbService;
    }

    /**
     * Get all movies that the user has rated with full movie details from OMDB
     * Returns the same data structure as movie-search for consistency
     * 
     * @param int $userId
     * @param string $sortBy - 'created_at', 'rating', 'movie_title'  
     * @param string $sortDirection - 'asc', 'desc'
     * @return array
     */
    public function getUserRatedMoviesWithDetails(int $userId, string $sortBy = 'created_at', string $sortDirection = 'desc'): array
    {
        // Get user ratings from database
        $query = UserRating::where('user_id', $userId);

        // Apply sorting
        switch ($sortBy) {
            case 'rating':
                $query->orderBy('rating', $sortDirection);
                break;
            case 'movie_title':
                $query->orderBy('movie_title', $sortDirection);
                break;
            case 'created_at':
            default:
                $query->orderBy('created_at', $sortDirection);
                break;
        }

        $userRatings = $query->get();

        if ($userRatings->isEmpty()) {
            return [
                'movies' => [],
                'movieDetails' => [],
                'userRatings' => []
            ];
        }

        $movies = [];
        $movieDetails = [];
        $userRatingsArray = [];

        foreach ($userRatings as $rating) {
            // Try to get full movie details from OMDB API
            $movieDetail = $this->omdbService->getMovieDetails($rating->imdb_id);
            
            if ($movieDetail) {
                // Store in same format as movie-search
                $movies[] = [
                    'imdbID' => $rating->imdb_id,
                    'Title' => $rating->movie_title,
                    'Year' => $movieDetail['Year'] ?? 'N/A',
                    'Type' => $movieDetail['Type'] ?? 'movie',
                    'Poster' => $movieDetail['Poster'] ?? 'N/A'
                ];
                
                // Store full details (same as selectedMovieDetails in movie-search)
                $movieDetails[$rating->imdb_id] = $movieDetail;
            } else {
                // Fallback if OMDB API fails - use data from database
                $movies[] = [
                    'imdbID' => $rating->imdb_id,
                    'Title' => $rating->movie_title,
                    'Year' => 'N/A',
                    'Type' => 'movie',
                    'Poster' => 'N/A'
                ];
                
                $movieDetails[$rating->imdb_id] = [
                    'imdbID' => $rating->imdb_id,
                    'Title' => $rating->movie_title,
                    'Year' => 'N/A',
                    'Plot' => 'Movie details not available',
                    'Poster' => 'N/A'
                ];
            }
            
            // Store user rating data
            $userRatingsArray[$rating->imdb_id] = [
                'id' => $rating->id,
                'rating' => $rating->rating,
                'review' => $rating->review,
                'created_at' => $rating->created_at,
                'updated_at' => $rating->updated_at
            ];
        }

        return [
            'movies' => $movies,                    // Same format as $movies in movie-search
            'movieDetails' => $movieDetails,        // Same format as $movieDetails in movie-search  
            'userRatings' => $userRatingsArray     // Additional: user rating data by imdb_id
        ];
    }

    /**
     * Get just the user ratings without OMDB API calls
     */
    public function getUserRatingsOnly(int $userId, string $sortBy = 'created_at', string $sortDirection = 'desc'): Collection
    {
        $query = UserRating::where('user_id', $userId);

        switch ($sortBy) {
            case 'rating':
                $query->orderBy('rating', $sortDirection);
                break;
            case 'movie_title':
                $query->orderBy('movie_title', $sortDirection);
                break;
            case 'created_at':
            default:
                $query->orderBy('created_at', $sortDirection);
                break;
        }

        return $query->get();
    }
}
