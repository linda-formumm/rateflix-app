@props(['movie', 'userRating' => null])

<div class="bg-white dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
    @if($userRating)
        <!-- User has already rated - show existing rating -->
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
            Your Rating
        </h3>
        
        <div class="space-y-4">
            <!-- Show current rating -->
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <x-star-rating :rating="$userRating->rating" size="lg" />
                    <span class="text-xl font-bold text-gray-900 dark:text-gray-100">
                        {{ $userRating->rating }}/5
                    </span>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Rated {{ $userRating->created_at->diffForHumans() }}
                </p>
            </div>
            
            @if($userRating->review)
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Your Review
                    </label>
                    <div class="p-3 bg-gray-50 dark:bg-zinc-700 rounded-lg">
                        <p class="text-gray-700 dark:text-gray-300">{{ $userRating->review }}</p>
                    </div>
                </div>
            @endif
            
            <!-- Delete Button -->
            <div class="pt-2">
                <button type="button"
                        wire:click="deleteUserRating('{{ $movie['imdbID'] }}')"
                        wire:confirm="Are you sure you want to delete your rating?"
                        wire:loading.attr="disabled"
                        wire:target="deleteUserRating"
                        class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 disabled:opacity-50 px-4 py-2 rounded-lg font-medium transition-colors cursor-pointer flex items-center gap-2">
                    
                    <!-- Loading Spinner -->
                    <svg wire:loading wire:target="deleteUserRating" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    
                    <!-- Button Text -->
                    <span wire:loading.remove wire:target="deleteUserRating">Delete my Rating</span>
                    <span wire:loading wire:target="deleteUserRating">Deleting...</span>
                </button>
            </div>
        </div>
    @else
        <!-- User hasn't rated yet - show rating form -->
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
            Rate This Movie
        </h3>
        
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-300 rounded-lg">
                {{ session('error') }}
            </div>
        @endif
        
        <form wire:submit="saveUserRating" class="space-y-4">
            <!-- Rating Stars -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Your Rating <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center gap-1">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" 
                                wire:click="$set('ratingData.rating', {{ $i }})"
                                class="text-2xl transition-colors cursor-pointer {{ $i <= ($this->ratingData['rating'] ?? 0) ? 'text-yellow-400' : 'text-gray-300 hover:text-yellow-400' }}">
                            ★
                        </button>
                    @endfor
                    @if(($this->ratingData['rating'] ?? 0) > 0)
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ $this->ratingData['rating'] ?? 0 }}/5
                        </span>
                    @endif
                </div>
                @error('ratingData.rating')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Review -->
            <div>
                <label for="review" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Your Review (Optional)
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        {{ strlen($this->ratingData['review'] ?? '') }}/1000 characters
                    </span>
                </label>
                <textarea 
                    wire:model.live="ratingData.review"
                    rows="4" 
                    maxlength="1000"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-gray-100"
                    placeholder="Share your thoughts about this movie..."></textarea>
                @error('ratingData.review')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Submit Button -->
            <button type="submit" 
                    wire:loading.attr="disabled"
                    wire:target="saveUserRating"
                    class="bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white px-6 py-2 rounded-lg font-medium transition-colors cursor-pointer flex items-center gap-2"
                    @disabled(!($this->ratingData['rating'] ?? 0) > 0)>
                
                <!-- Loading Spinner -->
                <svg wire:loading wire:target="saveUserRating" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                
                <!-- Button Text -->
                <span wire:loading.remove wire:target="saveUserRating">Save Rating</span>
                <span wire:loading wire:target="saveUserRating">Saving...</span>
            </button>
        </form>
    @endif
</div>
