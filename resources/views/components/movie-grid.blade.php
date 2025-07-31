@props(['movies', 'mode' => 'default'])

<div class="mt-4 grid gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4" role="list" aria-label="Movie search results">
    @foreach($movies as $movie)
        <x-movie-card 
            :movie="$movie"
            :mode="$mode"
            role="listitem" />
    @endforeach
</div>
