@props(['movie'])

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
        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center gap-3">
            <button 
                wire:click="showMovieDetails('{{ $movie['imdbID'] }}', 'details')"
                class="bg-white/90 hover:bg-white text-gray-900 px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 backdrop-blur-sm cursor-pointer"
                aria-label="View details for {{ $movie['Title'] }}">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Details
            </button>
            
            <button 
                wire:click="showMovieDetails('{{ $movie['imdbID'] }}', 'ratings')"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 cursor-pointer"
                aria-label="Rate {{ $movie['Title'] }}">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                Rate
            </button>
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
        
        <!-- Mobile/Touch Buttons (visible on touch devices or small screens) -->
        <div class="lg:hidden flex gap-2">
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
        </div>
    </div>
</div>
