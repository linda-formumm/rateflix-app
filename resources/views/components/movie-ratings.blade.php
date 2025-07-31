@props(['movie', 'details'])

@php
// Lade echte Rating-Daten aus der Datenbank
$userRating = auth()->check() 
    ? \App\Models\UserRating::where('user_id', auth()->id())
                            ->where('imdb_id', $movie['imdbID'])
                            ->first()
    : null;

$communityRatings = \App\Models\UserRating::where('imdb_id', $movie['imdbID'])
                                         ->with('user')
                                         ->latest()
                                         ->take(10)
                                         ->get();

$totalRatings = $communityRatings->count();
$averageRating = $totalRatings > 0 ? $communityRatings->avg('rating') : 0;
@endphp

<div class="space-y-6">
    <!-- User Rating Form -->
    <x-user-rating-form :movie="$movie" :user-rating="$userRating" />
    
    <!-- Community Ratings Display -->
    <x-community-ratings 
        :ratings="$communityRatings" 
        :average-rating="$averageRating" 
        :total-ratings="$totalRatings" />
</div>
