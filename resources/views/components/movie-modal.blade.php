@props(['show' => false, 'movie' => null, 'movieDetails' => null, 'activeTab' => 'details'])

@if($show && $movie)
<div 
    class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/40 dark:!bg-zinc-900/75 backdrop-blur-sm"
    role="dialog" 
    aria-modal="true" 
    aria-labelledby="modal-title">
    
    <!-- Backdrop Click Area -->
    <div class="absolute inset-0 z-[9998]" 
         {{ $attributes->whereStartsWith('wire:') }}
         aria-hidden="true"></div>
    
    <!-- Modal Content -->
    <div class="relative z-[9999] bg-white dark:bg-zinc-800 rounded-xl shadow-2xl dark:shadow-black/50 ring-1 ring-black/5 dark:ring-white/10 w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        
        <!-- Close X -->
        <button 
            {{ $attributes->whereStartsWith('wire:') }} 
            class="absolute top-4 right-4 z-[9999] p-2 rounded-full text-gray-400 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-slate-500 dark:focus:ring-slate-400 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 cursor-pointer"
            aria-label="Close modal"
            id="modal-close-button">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <div class="p-6">
            <div class="flex gap-6 flex-wrap">
                <!-- Poster -->
                <div class="flex-shrink-0">
                    @if($movie['Poster'] && $movie['Poster'] !== 'N/A')
                        <img src="{{ $movie['Poster'] }}" 
                             alt="Movie poster for {{ $movie['Title'] }}" 
                             class="w-48 h-72 object-contain rounded bg-gray-100 dark:bg-zinc-800">
                    @else
                        <div class="w-48 h-72 rounded bg-gray-200 dark:bg-zinc-800 flex items-center justify-center"
                             role="img"
                             aria-label="No poster available">
                            <span class="text-gray-500 dark:text-gray-400">No Poster</span>
                        </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="flex-1 min-w-[300px] min-h-[500px]">
                    <h2 id="modal-title" 
                        class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">
                        {{ $movie['Title'] }}
                    </h2>
                    
                    <!-- Tab Navigation -->
                    <div class="border-b border-gray-200 dark:border-gray-600 mb-4">
                        <nav class="-mb-px flex space-x-8">
                            <!-- Details Tab -->
                            <button
                                wire:click="$set('activeTab', 'details')"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 cursor-pointer
                                    {{ $activeTab === 'details' 
                                        ? 'border-blue-500 text-blue-600 dark:text-blue-400' 
                                        : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300' }}">
                                Movie Details
                            </button>
                            
                            <!-- Community Ratings Tab -->
                            <button
                                wire:click="$set('activeTab', 'ratings')"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 cursor-pointer
                                    {{ $activeTab === 'ratings' 
                                        ? 'border-blue-500 text-blue-600 dark:text-blue-400' 
                                        : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300' }}">
                                Community Ratings
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="min-h-[400px]">
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
            </div>

            <!-- Close Button -->
            <div class="mt-6 flex justify-end">
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
        
        // Auto-focus auf Close-Button
        const closeButton = document.getElementById('modal-close-button');
        if (closeButton) {
            closeButton.focus();
        }
        
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
            document.removeEventListener('keydown', escapeHandler);
        });
    </script>
</div>
@else
<div style="display: none;" aria-hidden="true"></div>
@endif
