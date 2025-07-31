@props(['movie'])

<div class="p-4 border border-gray-300 dark:border-gray-600 rounded 
            bg-white dark:bg-zinc-900 
            text-gray-900 dark:text-gray-100 
            shadow-sm hover:shadow-md transition-all duration-200
            focus:outline-none focus:ring-2 focus:ring-slate-500 dark:focus:ring-slate-400 focus:ring-offset-2 
            hover:border-gray-400 dark:hover:border-gray-500">
    
    @if($movie['Poster'] && $movie['Poster'] !== 'N/A')
        <img src="{{ $movie['Poster'] }}" 
             alt="Movie poster for {{ $movie['Title'] }}" 
             loading="lazy"
             class="w-full h-48 object-contain bg-gray-100 dark:bg-zinc-800 rounded mb-3">
    @else
        <div class="w-full h-48 bg-gray-200 dark:bg-zinc-800 rounded mb-3 flex items-center justify-content-center">
            <span class="text-gray-500 dark:text-gray-400" aria-hidden="true">No Poster</span>
        </div>
    @endif
    
    <h3 class="text-lg font-bold mb-2 text-gray-900 dark:text-gray-100">{{ $movie['Title'] }}</h3>
    
    <div class="text-sm text-gray-500 dark:text-gray-400 mb-3">
        {{ $movie['Year'] ?? 'N/A' }} • {{ ucfirst($movie['Type']) }}
    </div>
    
    <div class="flex flex-col gap-2">
        <!-- View Details Button -->
        <button 
            wire:click="showMovieDetails('{{ $movie['imdbID'] }}', 'details')"
            class="btn btn-secondary btn-sm w-full"
            aria-label="View details for {{ $movie['Title'] }}">
            View Details
        </button>
        
        <!-- Rate Movie Button -->
        <button 
            wire:click="showMovieDetails('{{ $movie['imdbID'] }}', 'ratings')"
            class="btn btn-primary btn-sm w-full"
            aria-label="Rate {{ $movie['Title'] }}">
            Rate Movie
        </button>
    </div>
</div>
