@props(['movie', 'userRating' => null])

<div class="bg-white dark:bg-zinc-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
        Rate This Movie
    </h3>
    
    <form class="space-y-4">
        <!-- Rating Stars -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Your Rating
            </label>
            <div class="flex items-center gap-1">
                @for($i = 1; $i <= 5; $i++)
                    <button type="button" 
                            class="text-2xl text-gray-300 hover:text-yellow-400 transition-colors cursor-pointer"
                            onclick="setRating({{ $i }})">
                        ★
                    </button>
                @endfor
                <span id="rating-text" class="ml-2 text-sm text-gray-600 dark:text-gray-400"></span>
            </div>
        </div>
        
        <!-- Review -->
        <div>
            <label for="review" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Your Review (Optional)
            </label>
            <textarea 
                id="review"
                rows="4" 
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-gray-100"
                placeholder="Share your thoughts about this movie..."></textarea>
        </div>
        
        <!-- Submit Button -->
        <button type="button" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors cursor-pointer">
            Save Rating
        </button>
    </form>
</div>

<script>
let currentRating = 0;

function setRating(rating) {
    currentRating = rating;
    
    // Update stars visually
    const stars = document.querySelectorAll('button[onclick*="setRating"]');
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.remove('text-gray-300');
            star.classList.add('text-yellow-400');
        } else {
            star.classList.remove('text-yellow-400');
            star.classList.add('text-gray-300');
        }
    });
    
    // Update rating text
    document.getElementById('rating-text').textContent = rating + '/5';
}
</script>
