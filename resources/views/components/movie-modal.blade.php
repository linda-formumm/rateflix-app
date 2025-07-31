@props(['show' => false, 'movie' => null, 'movieDetails' => null])

@if($show && $movie && $movieDetails)
<div 
    style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 99999999; display: flex; align-items: center; justify-content: center; padding: 1rem; background: rgba(0,0,0,0.4);"
    class="dark:!bg-black/80"
    role="dialog" 
    aria-modal="true" 
    aria-labelledby="modal-title">
    
    <!-- Backdrop Click Area -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;" 
         {{ $attributes->whereStartsWith('wire:') }}
         aria-hidden="true"></div>
    
    <!-- Modal Content -->
    <div style="position: relative; border-radius: 0.5rem; max-width: 56rem; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);" 
         class="bg-white dark:bg-zinc-900">
        
        <!-- Close X -->
        <button 
            {{ $attributes->whereStartsWith('wire:') }} 
            style="position: absolute; top: 1rem; right: 1rem; z-index: 10; background: none; border: none; padding: 0.5rem; border-radius: 9999px; cursor: pointer;"
            class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:ring-offset-2 dark:focus:ring-offset-zinc-900"
            aria-label="Close modal"
            id="modal-close-button">
            <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <div style="padding: 1.5rem;">
            <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
                <!-- Poster -->
                <div style="flex-shrink: 0;">
                    @if($movie['Poster'] && $movie['Poster'] !== 'N/A')
                        <img src="{{ $movie['Poster'] }}" 
                             alt="Movie poster for {{ $movie['Title'] }}" 
                             style="width: 12rem; height: 18rem; object-fit: contain; border-radius: 0.25rem;" 
                             class="bg-gray-100 dark:bg-zinc-800">
                    @else
                        <div style="width: 12rem; height: 18rem; border-radius: 0.25rem; display: flex; align-items: center; justify-content: center;" 
                             class="bg-gray-200 dark:bg-zinc-800"
                             role="img"
                             aria-label="No poster available">
                            <span class="text-gray-500 dark:text-gray-400">No Poster</span>
                        </div>
                    @endif
                </div>

                <!-- Details -->
                <div style="flex: 1; min-width: 300px;">
                    <h2 id="modal-title" 
                        style="font-size: 1.5rem; font-weight: bold; margin-bottom: 0.5rem;" 
                        class="text-gray-900 dark:text-gray-100">
                        {{ $movie['Title'] }}
                    </h2>
                    
                    <x-movie-details :movie="$movie" :details="$movieDetails" />
                </div>
            </div>

            <!-- Close Button -->
            <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end;">
                <button 
                    {{ $attributes->whereStartsWith('wire:') }} 
                    style="padding: 0.5rem 1rem; border: none; border-radius: 0.25rem; cursor: pointer; font-weight: 500;"
                    class="bg-gray-600 hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:ring-offset-2 dark:focus:ring-offset-zinc-900 transition-colors duration-200"
                    aria-label="Close modal">
                    Close
                </button>
            </div>
        </div>
    </div>
    
    <script>
        // Body-Lock: Verhindert Scrollen im Hintergrund
        document.body.style.overflow = 'hidden';
        document.body.style.paddingRight = (window.innerWidth - document.documentElement.clientWidth) + 'px';
        
        // Auto-focus und ESC-Taste für Modal
        document.addEventListener('DOMContentLoaded', function() {
            const closeButton = document.getElementById('modal-close-button');
            if (closeButton) {
                closeButton.focus();
            }
        });
        
        // ESC-Taste Event
        const escapeHandler = function(e) {
            if (e.key === 'Escape') {
                @this.closeModal();
                document.removeEventListener('keydown', escapeHandler);
            }
        };
        document.addEventListener('keydown', escapeHandler);
        
        // Cleanup wenn Modal geschlossen wird
        window.addEventListener('beforeunload', function() {
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        });
    </script>
</div>
@else
<div style="display: none;" aria-hidden="true"></div>
@endif
