@props(['movie', 'details'])

<!-- Summary Line -->
<div class="text-sm text-gray-500 dark:text-gray-400 mb-4 pb-2 border-b border-gray-200 dark:border-gray-600">
    {{ $movie['Year'] ?? 'N/A' }}
    @if(isset($details['Rated']) && $details['Rated'] !== 'N/A')
        • @php
            $ageRatings = [
                'G' => 'All Ages', 'PG' => '6+', 'PG-13' => '12+', 'R' => '16+', 'NC-17' => '18+',
                'T' => 'Teen', 'E' => 'Everyone', 'M' => 'Mature', 'TV-G' => 'All Ages', 'TV-PG' => '6+',
                'TV-14' => '14+', 'TV-MA' => '17+'
            ];
            echo $ageRatings[$details['Rated']] ?? $details['Rated'];
        @endphp
    @endif
    @if(isset($details['Runtime']) && $details['Runtime'] !== 'N/A')
        • {{ $details['Runtime'] }}
    @endif
</div>

<!-- IMDB Rating -->
@if(isset($details['imdbRating']) && $details['imdbRating'] !== 'N/A')
    <div class="mb-4">
        <div class="flex items-center gap-2 mb-1">
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">IMDB Rating:</span>
        </div>
        <div class="flex items-center">
            <span class="text-yellow-500 text-lg">⭐</span>
            <span class="text-lg font-semibold text-gray-900 dark:text-gray-100 ml-1">{{ $details['imdbRating'] }}/10</span>
            @if(isset($details['imdbVotes']) && $details['imdbVotes'] !== 'N/A')
                <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">({{ $details['imdbVotes'] }} votes)</span>
            @endif
        </div>
    </div>
@endif

<!-- Genre -->
@if(isset($details['Genre']) && $details['Genre'] !== 'N/A')
    <div class="mb-3">
        <span class="font-semibold text-gray-700 dark:text-gray-300">Genre:</span>
        <span class="text-gray-600 dark:text-gray-400">{{ $details['Genre'] }}</span>
    </div>
@endif

<!-- Director -->
@if(isset($details['Director']) && $details['Director'] !== 'N/A')
    <div class="mb-3">
        <span class="font-semibold text-gray-700 dark:text-gray-300">Director:</span>
        <span class="text-gray-600 dark:text-gray-400">{{ $details['Director'] }}</span>
    </div>
@endif

<!-- Cast -->
@if(isset($details['Actors']) && $details['Actors'] !== 'N/A')
    <div class="mb-3">
        <span class="font-semibold text-gray-700 dark:text-gray-300">Cast:</span>
        <span class="text-gray-600 dark:text-gray-400">{{ $details['Actors'] }}</span>
    </div>
@endif

<!-- Plot -->
@if(isset($details['Plot']) && $details['Plot'] !== 'N/A')
    <div class="mb-4">
        <span class="font-semibold text-gray-700 dark:text-gray-300">Plot:</span>
        <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $details['Plot'] }}</p>
    </div>
@endif
