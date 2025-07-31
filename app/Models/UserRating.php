<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRating extends Model
{
    protected $fillable = [
        'user_id',
        'imdb_id',
        'movie_title',
        'rating',
        'review'
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Get the user that owns the rating
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get ratings for a specific movie
     */
    public function scopeForMovie($query, string $imdbId)
    {
        return $query->where('imdb_id', $imdbId);
    }

    /**
     * Scope to get average rating for a movie
     */
    public function scopeAverageRatingFor($query, string $imdbId)
    {
        return $query->where('imdb_id', $imdbId)->avg('rating');
    }

    /**
     * Scope to count ratings for a movie
     */
    public function scopeCountFor($query, string $imdbId)
    {
        return $query->where('imdb_id', $imdbId)->count();
    }
}
