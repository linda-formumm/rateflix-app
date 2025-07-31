@props(['movie', 'userRating' => null])

<div class="bg-white dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
        @if($userRating)
            Update Your Rating
        @else
            Rate This Movie
        @endif
    </h3>
    
    <div x-data="{ 
        rating: {{ $userRating->rating ?? 0 }}, 
        review: '{{ $userRating->review ?? '' }}',
        isSubmitting: false,
        showSuccess: false,
        
        async submitRating() {
            if (this.rating === 0) {
                alert('Please select a rating');
                return;
            }
            
            this.isSubmitting = true;
            
            try {
                await $wire.saveUserRating({
                    imdb_id: '{{ $movie['imdbID'] }}',
                    rating: this.rating,
                    review: this.review
                });
                
                this.showSuccess = true;
                setTimeout(() => this.showSuccess = false, 3000);
            } catch (error) {
                console.error('Error saving rating:', error);
                alert('Error saving rating. Please try again.');
            } finally {
                this.isSubmitting = false;
            }
        },
        
        async deleteRating() {
            if (!confirm('Are you sure you want to delete your rating?')) return;
            
            this.isSubmitting = true;
            
            try {
                await $wire.deleteUserRating('{{ $movie['imdbID'] }}');
                this.rating = 0;
                this.review = '';
                this.showSuccess = true;
                setTimeout(() => this.showSuccess = false, 3000);
            } catch (error) {
                console.error('Error deleting rating:', error);
                alert('Error deleting rating. Please try again.');
            } finally {
                this.isSubmitting = false;
            }
        }
    }">
        
        <!-- Success Message -->
        <div x-show="showSuccess" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-90"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-90"
             class="mb-4 p-3 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                Rating saved successfully!
            </div>
        </div>
        
        <!-- Rating Section -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Your Rating
            </label>
            <x-star-rating 
                :rating="0" 
                :interactive="true" 
                size="lg" 
                :show-value="true"
                wire-model="rating" />
        </div>
        
        <!-- Review Section -->
        <div class="mb-6">
            <label for="review" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Your Review (Optional)
            </label>
            <textarea 
                id="review"
                x-model="review"
                rows="4" 
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-gray-100 resize-none"
                placeholder="Share your thoughts about this movie..."></textarea>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex items-center justify-between">
            <button 
                @click="submitRating()"
                :disabled="rating === 0 || isSubmitting"
                class="bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center cursor-pointer"
                :class="{ 'opacity-50': isSubmitting }">
                
                <svg x-show="isSubmitting" class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                
                <span x-text="isSubmitting ? 'Saving...' : '{{ $userRating ? 'Update Rating' : 'Save Rating' }}'"></span>
            </button>
            
            @if($userRating)
                <button 
                    @click="deleteRating()"
                    :disabled="isSubmitting"
                    class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 px-4 py-2 rounded-lg font-medium transition-colors duration-200 cursor-pointer"
                    :class="{ 'opacity-50': isSubmitting }">
                    Delete Rating
                </button>
            @endif
        </div>
    </div>
</div>
