@props(['movie', 'mode' => 'default']) {{-- default, user-ratings --}}

@php
// Lade Rating-Daten für diese Movie Card
$userRating = auth()->check() 
    ? \App\Models\UserRating::where('user_id', auth()->id())
                            ->where('imdb_id', $movie['imdbID'])
                            ->first()
    : null;

$communityRating = \App\Models\UserRating::where('imdb_id', $movie['imdbID'])
                                        ->avg('rating');
$ratingCount = \App\Models\UserRating::where('imdb_id', $movie['imdbID'])->count();
@endphp

<div class="group relative bg-white dark:bg-zinc-900 rounded-lg shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600">
    
    <!-- Poster Container with Overlay -->
    <div class="relative overflow-hidden bg-gray-100 dark:bg-zinc-800">
        @if($movie['Poster'] && $movie['Poster'] !== 'N/A')
            <img src="{{ $movie['Poster'] }}" 
                 alt="Movie poster for {{ $movie['Title'] }}" 
                 loading="lazy"
                 class="w-full h-64 object-contain group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="w-full h-64 bg-gray-200 dark:bg-zinc-800 flex items-center justify-center">
                <span class="text-gray-500 dark:text-gray-400" aria-hidden="true">No Poster</span>
            </div>
        @endif
        
        <!-- Hover Overlay with Quick Actions -->
                <!-- Overlay Buttons (visible on hover for desktop) -->
        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 items-center justify-center gap-3 hidden lg:flex">
            @if($mode === 'user-ratings')
                <!-- Delete Rating Button for User Ratings page -->
                <button 
                    wire:click="deleteRating('{{ $movie['imdbID'] }}')"
                    wire:confirm="Are you sure you want to delete your rating for {{ $movie['Title'] }}?"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 cursor-pointer"
                    aria-label="Delete rating for {{ $movie['Title'] }}">
                    Delete my Rating
                </button>
            @else
                <!-- Default buttons -->
                <button 
                    wire:click="showMovieDetails('{{ $movie['imdbID'] }}', 'details')"
                    class="bg-white/90 hover:bg-white text-gray-800 px-4 py-2 rounded-lg font-medium transition-colors duration-200 cursor-pointer"
                    aria-label="View details for {{ $movie['Title'] }}">
                    Details
                </button>
                
                <button 
                    wire:click="showMovieDetails('{{ $movie['imdbID'] }}', 'ratings')"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 cursor-pointer"
                    aria-label="Rate {{ $movie['Title'] }}">
                    Rate
                </button>
            @endif
        </div>
    </div>
    
    <!-- Content Area -->
    <div class="p-4">
        <h3 class="text-lg font-bold mb-2 text-gray-900 dark:text-gray-100 line-clamp-2 leading-tight">
            {{ $movie['Title'] }}
        </h3>
        
        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-3">
            <span>{{ $movie['Year'] ?? 'N/A' }}</span>
            <span class="bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded text-xs font-medium">
                {{ ucfirst($movie['Type']) }}
            </span>
        </div>
        
        <!-- Rating Display -->
    
        @if($communityRating && $ratingCount > 0)
            <!-- Show community rating if no user rating -->
            <div class="flex items-center gap-2 mb-3">
                <x-star-rating :rating="round($communityRating)" size="sm" />
                <span class="text-xs text-gray-600 dark:text-gray-400">
                    {{ number_format($communityRating, 1) }} ({{ $ratingCount }})
                </span>
            </div>
        @endif
        
        <!-- Mobile/Touch Buttons (visible on touch devices or small screens) -->
        <div class="lg:hidden flex gap-2">
            @if($mode === 'user-ratings')
                <!-- Delete Rating Button for User Ratings page -->
                <button 
                    wire:click="deleteRating('{{ $movie['imdbID'] }}')"
                    wire:confirm="Are you sure you want to delete your rating for {{ $movie['Title'] }}?"
                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-sm font-medium transition-colors duration-200 flex-1 cursor-pointer"
                    aria-label="Delete my rating for {{ $movie['Title'] }}">
                    Delete my Rating
                </button>
            @else
                <!-- Default buttons -->
                <button 
                    wire:click="showMovieDetails('{{ $movie['imdbID'] }}', 'details')"
                    class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 px-3 py-1.5 rounded text-sm font-medium transition-colors duration-200 flex-1 cursor-pointer"
                    aria-label="View details for {{ $movie['Title'] }}">
                    Details
                </button>
                
                <button 
                    wire:click="showMovieDetails('{{ $movie['imdbID'] }}', 'ratings')"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-sm font-medium transition-colors duration-200 flex-1 cursor-pointer"
                    aria-label="Rate {{ $movie['Title'] }}">
                    Rate
                </button>
            @endif
        </div>
    </div>
</div>
