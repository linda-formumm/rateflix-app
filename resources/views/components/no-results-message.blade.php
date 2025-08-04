@props(['query' => null])

<div class="mt-4 p-4 border border-yellow-300 dark:border-yellow-600 rounded 
            bg-yellow-50 dark:bg-yellow-900/20 
            text-yellow-800 dark:text-yellow-200">
    @if($query)
        <p>No movies found with the title "{{ $query }}".</p>
    @else
        <p>You haven't rated any movies yet. Start rating movies to see them here!</p>
    @endif
</div>
