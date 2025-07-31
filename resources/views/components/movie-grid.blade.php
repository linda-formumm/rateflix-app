@props(['movies'])

<div class="mt-4 grid gap-4 md:grid-cols-2 lg:grid-cols-3" role="list" aria-label="Movie search results">
    @foreach($movies as $movie)
        <x-movie-card 
            :movie="$movie"
            role="listitem" />
    @endforeach
</div>
