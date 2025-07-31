<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Url;
use App\Services\OmdbService;

new class extends Component {
    #[Url(as: 'q', except: '')]
    public string $query = 'Matrix';
    
    public ?array $movies = null;
    public array $movieDetails = [];
    public bool $isLoading = false;
    public ?array $selectedMovie = null;
    public ?array $selectedMovieDetails = null;
    public bool $showModal = false;

    public function mount()
    {
        // Führe Suche aus, falls Query bereits gesetzt ist (z.B. aus URL)
        if (strlen($this->query) >= 3) {
            $this->search();
        }
    }

    public function updatedQuery()
    {                
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

    public function showMovieDetails($imdbId)
    {
        $this->selectedMovie = collect($this->movies)->firstWhere('imdbID', $imdbId);
        
        if (!isset($this->movieDetails[$imdbId])) {
            $omdbService = app(OmdbService::class);
            $details = $omdbService->getMovieDetails($imdbId);
            if ($details) {
                $this->movieDetails[$imdbId] = $details;
            }
        }
        
        $this->selectedMovieDetails = $this->movieDetails[$imdbId] ?? null;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedMovie = null;
        $this->selectedMovieDetails = null;
        
        // JavaScript zum Entsperren des Body
        $this->dispatch('unlock-body');
    }
}; ?>

<div class="relative z-10 p-4">
    <x-search-input wire:model.live.debounce.750ms="query" placeholder="Enter movie title" value="{{ $query }}" />

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


