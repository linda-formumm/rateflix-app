@props(['ratings' => [], 'averageRating' => 0, 'totalRatings' => 0])

<div class="space-y-6">
    
    @if($totalRatings > 0)
        <!-- Average Rating Summary -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-zinc-800 dark:to-zinc-700 rounded-lg p-6 border border-blue-200 dark:border-zinc-600">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        Community Rating
                    </h4>
                    <div class="flex items-center gap-3">
                        <x-star-rating :rating="round($averageRating)" size="lg" :show-value="false" />
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                            {{ number_format($averageRating, 1) }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            ({{ $totalRatings }} {{ Str::plural('rating', $totalRatings) }})
                        </div>
                    </div>
                </div>
                
                <!-- Rating Distribution (Optional - can be added later) -->
                <div class="hidden lg:block">
                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-1">Rating Distribution</div>
                    <div class="flex items-center gap-1">
                        @for($i = 5; $i >= 1; $i--)
                            @php
                                $count = collect($ratings)->where('rating', $i)->count();
                                $percentage = $totalRatings > 0 ? ($count / $totalRatings) * 100 : 0;
                            @endphp
                            <div class="flex items-center text-xs">
                                <span class="w-2 text-gray-600 dark:text-gray-400">{{ $i }}</span>
                                <div class="w-12 h-2 bg-gray-200 dark:bg-gray-600 rounded-full mx-1">
                                    <div class="h-2 bg-yellow-400 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- No Ratings Yet -->
        <div class="text-center py-12 bg-gray-50 dark:bg-zinc-800/50 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No ratings yet</h3>
            <p class="text-gray-500 dark:text-gray-400">Be the first to rate this movie!</p>
        </div>
    @endif
    
    @if(count($ratings) > 0)
        <!-- Individual Ratings List -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                Recent Reviews
            </h4>
            
            <div class="space-y-4 max-h-96 overflow-y-auto">
                @foreach($ratings as $rating)
                    <div class="bg-white dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <!-- User Avatar/Initial -->
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                    {{ strtoupper(substr($rating->user->name, 0, 1)) }}
                                </div>
                                
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $rating->user->name }}
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <x-star-rating :rating="$rating->rating" size="sm" :show-value="false" />
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $rating->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Rating Score -->
                            <div class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                {{ $rating->rating }}/5
                            </div>
                        </div>
                        
                        @if($rating->review)
                            <div class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed">
                                {{ $rating->review }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            
            @if(count($ratings) >= 5)
                <div class="text-center mt-4">
                    <button class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium cursor-pointer">
                        Load More Reviews
                    </button>
                </div>
            @endif
        </div>
    @endif
</div>
