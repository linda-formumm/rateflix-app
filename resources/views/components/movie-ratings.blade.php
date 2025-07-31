@props(['movie', 'details'])

<div class="space-y-4">
    <!-- Community Average - Kompakt -->
    <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-800/30 rounded-lg p-3">
        <div>
            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-1">Community Average</h3>
            <div class="flex items-center gap-2">
                <span class="text-zinc-400">★★★★☆</span>
                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">0.0/5</span>
                <span class="text-xs text-gray-500 dark:text-gray-400">(0 ratings)</span>
            </div>
        </div>
    </div>

    <!-- Rate This Movie - Kompakter -->
    <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-4">
        <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">Rate this movie</h4>
        
        <!-- Rating Stars - Kompakter -->
        <div class="mb-3">
            <div class="flex items-center gap-1 mb-2">
                <button class="text-2xl text-gray-300 hover:text-yellow-500 transition-colors duration-200 leading-none">★</button>
                <button class="text-2xl text-gray-300 hover:text-yellow-500 transition-colors duration-200 leading-none">★</button>
                <button class="text-2xl text-gray-300 hover:text-yellow-500 transition-colors duration-200 leading-none">★</button>
                <button class="text-2xl text-gray-300 hover:text-yellow-500 transition-colors duration-200 leading-none">★</button>
                <button class="text-2xl text-gray-300 hover:text-yellow-500 transition-colors duration-200 leading-none">★</button>
                <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">Click to rate</span>
            </div>
        </div>

        <!-- Review Text - Kompakter -->
        <div class="mb-3">
            <textarea 
                class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100 resize-none" 
                rows="3" 
                placeholder="Optional: Share your thoughts...">
            </textarea>
        </div>

        <!-- Submit Button - Kompakter -->
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
            Submit Rating
        </button>
    </div>

    <!-- Recent Reviews - Kompakter -->
    <div class="border-t border-gray-200 dark:border-gray-600 pt-3">
        <div class="flex items-center justify-between mb-2">
            <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">Recent Reviews</h4>
            <span class="text-xs text-gray-500 dark:text-gray-400">0 reviews</span>
        </div>
        <div class="text-xs text-gray-500 dark:text-gray-400 text-center py-4 bg-gray-50 dark:bg-gray-800/30 rounded">
            No reviews yet. Be the first!
        </div>
    </div>
</div>
