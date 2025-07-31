@props(['movie', 'details'])

@php
// Mock data - wird später durch echte Daten ersetzt
$userRating = null; // Current user's rating for this movie
$communityRatings = []; // All community ratings
$averageRating = 0;
$totalRatings = 0;
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
