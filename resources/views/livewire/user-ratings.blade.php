<?php

use Livewire\Volt\Component;
use App\Services\OmdbService;
use App\Services\UserRatingService;
use App\Models\UserRating;

new class extends Component {
    public array $movies = [];
    public array $movieDetails = [];
    public array $userRatings = [];
    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';
    public ?array $selectedMovie = null;

    public function mount()
    {
        $this->loadUserRatedMovies();
    }

    public function loadUserRatedMovies()
    {
        $userRatingService = app(UserRatingService::class);

        $data = $userRatingService->getUserRatedMoviesWithDetails(
            auth()->id(),
            $this->sortBy,
            $this->sortDirection
        );

        $this->movies = $data['movies'];
        $this->userRatings = $data['userRatings'];
    }

    public function deleteRating($imdbId)
    {
        UserRating::where('user_id', auth()->id())
            ->where('imdb_id', $imdbId)
            ->delete();

        $this->loadUserRatedMovies();
        session()->flash('success', 'Rating deleted successfully!');
    }
}; ?>

<div>
      @if($movies && count($movies) > 0)
        <x-movie-grid :movies="$movies" mode="user-ratings" />
    @else
        <x-no-results-message />
    @endif
</div>
