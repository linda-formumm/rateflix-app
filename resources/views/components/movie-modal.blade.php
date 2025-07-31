@props(['show' => false, 'movie' => null, 'movieDetails' => null, 'activeTab' => 'details'])

@if($show && $movie)
<div 
    style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 99999999; display: flex; align-items: center; justify-content: center; padding: 1rem; background: rgba(0,0,0,0.4);"
    class="dark:!bg-zinc-900/75 backdrop-blur-sm"
    role="dialog" 
    aria-modal="true" 
    aria-labelledby="modal-title">
    
    <!-- Backdrop Click Area -->
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;" 
         {{ $attributes->whereStartsWith('wire:') }}
         aria-hidden="true"></div>
    
    <!-- Modal Content -->
    <div style="position: relative; border-radius: 0.75rem; max-width: 56rem; width: 100%; max-height: 90vh; overflow-y: auto;" 
         class="bg-white dark:bg-zinc-800 shadow-2xl dark:shadow-black/50 ring-1 ring-black/5 dark:ring-white/10">
        
        <!-- Close X -->
        <button 
            {{ $attributes->whereStartsWith('wire:') }} 
            style="position: absolute; top: 1rem; right: 1rem; z-index: 10; background: none; border: none; padding: 0.5rem; border-radius: 9999px; cursor: pointer;"
            class="text-gray-400 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-slate-500 dark:focus:ring-slate-400 focus:ring-offset-2 dark:focus:ring-offset-zinc-800"
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

                <!-- Content -->
                <div style="flex: 1; min-width: 300px; min-height: 400px;">
                    <h2 id="modal-title" 
                        style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;" 
                        class="text-gray-900 dark:text-gray-100">
                        {{ $movie['Title'] }}
                    </h2>
                    
                    <!-- Tab Navigation -->
                    <div class="border-b border-gray-200 dark:border-gray-600 mb-4">
                        <nav class="-mb-px flex space-x-8">
                            <!-- Details Tab -->
                            <button
                                wire:click="$set('activeTab', 'details')"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors
                                    {{ $activeTab === 'details' 
                                        ? 'border-blue-500 text-blue-600 dark:text-blue-400' 
                                        : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300' }}">
                                Movie Details
                            </button>
                            
                            <!-- Community Ratings Tab -->
                            <button
                                wire:click="$set('activeTab', 'ratings')"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors
                                    {{ $activeTab === 'ratings' 
                                        ? 'border-blue-500 text-blue-600 dark:text-blue-400' 
                                        : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300' }}">
                                Community Ratings
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    @if($activeTab === 'details')
                        @if($movieDetails)
                            <x-movie-details :movie="$movie" :details="$movieDetails" />
                        @else
                            <x-movie-details-skeleton />
                        @endif
                    @elseif($activeTab === 'ratings')
                        @if($movieDetails)
                            <x-movie-ratings :movie="$movie" :details="$movieDetails" />
                        @else
                            <x-movie-ratings-skeleton />
                        @endif
                    @endif
                </div>
            </div>

            <!-- Close Button -->
            <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end;">
                <button 
                    {{ $attributes->whereStartsWith('wire:') }} 
                    class="btn btn-secondary"
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
