<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use App\Services\OmdbService;
use App\Models\UserRating;

new class extends Component {
    #[Url(as: 'q', except: '')]
    public string $query = '';
    
    public ?array $movies = null;
    public array $movieDetails = [];
    public bool $isLoading = false;
    public ?array $selectedMovie = null;
    public ?array $selectedMovieDetails = null;
    public bool $showModal = false;
    public string $activeTab = 'details';
    public array $ratingData = [
        'rating' => 0,
        'review' => ''
    ]; // Aktiver Tab im Modal

    public function mount()
    {
        // Führe Suche aus, falls Query bereits gesetzt ist (z.B. aus URL)
        if (strlen($this->query) >= 3) {
            $this->search();
        }
    }

    public function updatedQuery()
    {                
        // Frontend Validation for search input
        if (strlen($this->query) > 0 && strlen($this->query) < 3) {
            $this->movies = null;
            $this->isLoading = false;
            return;
        }

        if (strlen($this->query) >= 3) {
            $this->search();
        } else {
            $this->movies = null;
            $this->isLoading = false;
        }
    }

    private function search()
    {
        $this->isLoading = true;
        $omdbService = app(OmdbService::class);
        
        $this->movies = $omdbService->searchMovies($this->query);
        $this->isLoading = false;
    }

    public function showMovieDetails($imdbId, $tab = 'details')
    {
        $this->selectedMovie = collect($this->movies)->firstWhere('imdbID', $imdbId);
        $this->activeTab = $tab; // Tab setzen basierend auf Parameter
        
        // Modal sofort anzeigen
        $this->showModal = true;
        
        // Details laden - sofort wenn gecacht, sonst async
        if (isset($this->movieDetails[$imdbId])) {
            $this->selectedMovieDetails = $this->movieDetails[$imdbId];
        } else {
            $this->selectedMovieDetails = null;
            // Dispatch für sofortiges Rerendering und dann Details laden
            $this->dispatch('modal-opened');
        }
    }

    public function loadMovieDetailsAsync($imdbId)
    {
        $omdbService = app(OmdbService::class);
        $details = $omdbService->getMovieDetails($imdbId);
        if ($details) {
            $this->movieDetails[$imdbId] = $details;
            $this->selectedMovieDetails = $details;
        }
    }
    
    #[On('modal-opened')]
    public function handleModalOpened()
    {
        if ($this->selectedMovie && !$this->selectedMovieDetails) {
            $this->loadMovieDetailsAsync($this->selectedMovie['imdbID']);
        }
    }

    public function saveUserRating()
    {
        // Frontend + Backend Validation
        $this->validate([
            'ratingData.rating' => 'required|integer|min:1|max:5',
            'ratingData.review' => 'nullable|string|max:1000',
        ], [
            'ratingData.rating.required' => 'Please select a rating before saving.',
            'ratingData.rating.min' => 'Rating must be at least 1 star.',
            'ratingData.rating.max' => 'Rating cannot exceed 5 stars.',
            'ratingData.review.max' => 'Review cannot exceed 1000 characters.',
        ]);

        if (!auth()->check()) {
            session()->flash('error', 'Please login to rate movies.');
            return;
        }

        if (!$this->selectedMovie) {
            session()->flash('error', 'No movie selected.');
            return;
        }

        try {
            UserRating::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'imdb_id' => $this->selectedMovie['imdbID']
                ],
                [
                    'movie_title' => $this->selectedMovie['Title'],
                    'rating' => $this->ratingData['rating'],
                    'review' => $this->ratingData['review'] ?: null
                ]
            );

            session()->flash('success', 'Rating saved successfully!');
            
            // Reset rating aber behalte movie info
            $this->ratingData['rating'] = 0;
            $this->ratingData['review'] = '';
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save rating. Please try again.');
            \Log::error('Rating save error: ' . $e->getMessage());
        }
    }

    public function deleteUserRating($imdbId)
    {
        if (!auth()->check()) {
            return;
        }

        UserRating::where('user_id', auth()->id())
                  ->where('imdb_id', $imdbId)
                  ->delete();

        session()->flash('success', 'Rating deleted successfully!');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedMovie = null;
        $this->selectedMovieDetails = null;
        $this->activeTab = 'details'; // Tab zurücksetzen
        
        // JavaScript zum Entsperren des Body
        $this->dispatch('unlock-body');
    }
}; ?>

<div class="relative z-10 p-4">
    <x-search-input wire:model.live.debounce.750ms="query" placeholder="Enter movie title (e.g. Matrix)" value="{{ $query }}" />
    
    @if(strlen($query) > 0 && strlen($query) < 3)
        <div class="mt-2 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
            <p class="text-yellow-700 dark:text-yellow-300 text-sm">
                Please enter at least 3 characters to search for movies.
            </p>
        </div>
    @endif

    @if($isLoading)
        <x-movie-skeleton :count="10" />
    @elseif($movies && count($movies) > 0)
        <x-movie-grid :movies="$movies" />
    @elseif($query && strlen($query) >= 3)
        <x-no-results-message query="{{ $query }}" />
    @endif

    <x-movie-modal 
        :show="$showModal" 
        :movie="$selectedMovie" 
        :movie-details="$selectedMovieDetails"
        :active-tab="$activeTab"
        wire:click="closeModal" />
</div>

<script>
    // Event-Listener für Body-Unlock
    document.addEventListener('livewire:init', function() {
        Livewire.on('unlock-body', function() {
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        });
    });
</script>


