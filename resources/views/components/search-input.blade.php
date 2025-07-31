@props(['placeholder' => 'Search...'])

<div>
    <label for="movie-search" class="sr-only">Search for movies</label>
    <input type="text" 
           id="movie-search"
           {{ $attributes }}
           class="border border-gray-300 dark:border-gray-600 p-2 rounded w-full 
                  bg-white dark:bg-zinc-900 
                  text-gray-900 dark:text-gray-100 
                  placeholder-gray-500 dark:placeholder-gray-400 
                  focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400" 
           placeholder="{{ $placeholder }}"
           aria-describedby="search-help">
    <div id="search-help" class="sr-only">Type at least 3 characters to search for movies</div>
</div>
