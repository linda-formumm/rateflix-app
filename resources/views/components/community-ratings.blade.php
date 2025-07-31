@props(['ratings' => [], 'averageRating' => 0, 'totalRatings' => 0])

<div class="space-y-6">
    @if($totalRatings > 0)
        <!-- Average Rating -->
        <div class="bg-gray-50 dark:bg-zinc-800 rounded-lg p-4">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                Community Rating
            </h4>
            <div class="flex items-center gap-3">
                <x-star-rating :rating="round($averageRating)" size="lg" />
                <div class="text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{ number_format($averageRating, 1) }}/5
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    ({{ $totalRatings }} {{ Str::plural('rating', $totalRatings) }})
                </div>
            </div>
        </div>
        
        <!-- Reviews List -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                Recent Reviews
            </h4>
            <div class="space-y-4">
                @foreach($ratings as $rating)
                    <div class="bg-white dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                    {{ strtoupper(substr($rating->user->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $rating->user->name }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <x-star-rating :rating="$rating->rating" size="sm" />
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $rating->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        
                        @if($rating->review)
                            <p class="text-gray-700 dark:text-gray-300 text-sm">
                                {{ $rating->review }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <!-- No Ratings -->
        <div class="text-center py-8 bg-gray-50 dark:bg-zinc-800 rounded-lg">
            <div class="text-gray-400 text-4xl mb-2">⭐</div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-1">No ratings yet</h3>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Be the first to rate this movie!</p>
        </div>
    @endif
</div>
