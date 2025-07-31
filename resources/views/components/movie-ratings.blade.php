@props(['movie', 'details'])

<div class="space-y-6">
    <!-- Community Average -->
    <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Community Average</h3>
        <div class="flex items-center">
            <div class="flex items-center">
                {{-- Placeholder für Sterne-Anzeige --}}
                <span class="text-zinc-400 text-xl">★★★★☆</span>
                <span class="text-lg font-medium text-gray-900 dark:text-gray-100 ml-2">0.0/5</span>
                <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">(0 ratings)</span>
            </div>
        </div>
    </div>

    <!-- Rate This Movie -->
    <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-6">
        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Rate this movie</h4>
        
        <!-- Rating Stars -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Your rating
            </label>
            <div class="flex items-center gap-1">
                {{-- Placeholder für interaktive Sterne --}}
                <button class="text-3xl text-gray-300 hover:text-yellow-500 transition-colors duration-200">★</button>
                <button class="text-3xl text-gray-300 hover:text-yellow-500 transition-colors duration-200">★</button>
                <button class="text-3xl text-gray-300 hover:text-yellow-500 transition-colors duration-200">★</button>
                <button class="text-3xl text-gray-300 hover:text-yellow-500 transition-colors duration-200">★</button>
                <button class="text-3xl text-gray-300 hover:text-yellow-500 transition-colors duration-200">★</button>
            </div>
        </div>

        <!-- Review Text -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Your review (optional)
            </label>
            <textarea 
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 resize-none" 
                rows="4" 
                placeholder="Share your thoughts about this movie...">
            </textarea>
        </div>

        <!-- Submit Button -->
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-medium transition-colors duration-200">
            Submit Rating
        </button>
    </div>

    <!-- Recent Reviews (Placeholder) -->
    <div>
        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3">Recent Reviews</h4>
        <div class="text-sm text-gray-500 dark:text-gray-400 text-center py-8">
            No reviews yet. Be the first to review this movie!
        </div>
    </div>
</div>
