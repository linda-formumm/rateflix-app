<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
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
    public string $activeTab = 'details'; // Aktiver Tab im Modal

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


