<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class OmdbService
{
    private string $apiKey;
    private string $baseUrl = 'https://www.omdbapi.com/';
    private int $cacheMinutes = 60; // Cache for 1 hour

    public function __construct()
    {
        $this->apiKey = config('services.omdb.api_key', env('OMDB_API_KEY'));
    }

    /**
     * Search for movies by title
     */
    public function searchMovies(string $query): ?array
    {
        $cacheKey = 'omdb_search_' . md5(strtolower(trim($query)));
        
        return Cache::remember($cacheKey, $this->cacheMinutes * 60, function () use ($query) {
            $response = Http::get($this->baseUrl, [
                'apikey' => $this->apiKey,
                's' => $query,
            ]);

            if ($response->ok()) {
                $data = $response->json();
                
                if (isset($data['Response']) && $data['Response'] === 'True' && isset($data['Search'])) {
                    return $data['Search'];
                }
            }

            return null;
        });
    }

    /**
     * Get detailed movie information by IMDb ID
     */
    public function getMovieDetails(string $imdbId): ?array
    {
        $cacheKey = 'omdb_details_' . $imdbId;
        
        return Cache::remember($cacheKey, $this->cacheMinutes * 60, function () use ($imdbId) {
            $response = Http::get($this->baseUrl, [
                'apikey' => $this->apiKey,
                'i' => $imdbId,
            ]);

            if ($response->ok()) {
                $details = $response->json();
                
                if (isset($details['Response']) && $details['Response'] === 'True') {
                    return $details;
                }
            }

            return null;
        });
    }

    /**
     * Search movies and load their details
     */
    public function searchMoviesWithDetails(string $query): array
    {
        $movies = $this->searchMovies($query);
        $movieDetails = [];

        if ($movies) {
            foreach ($movies as $movie) {
                $details = $this->getMovieDetails($movie['imdbID']);
                if ($details) {
                    $movieDetails[$movie['imdbID']] = $details;
                }
            }
        }

        return [
            'movies' => $movies,
            'details' => $movieDetails
        ];
    }
}
