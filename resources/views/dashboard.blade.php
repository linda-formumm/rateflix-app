<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-neutral-500 to-neutral-600 dark:from-neutral-800 dark:to-neutral-900 rounded-xl p-8 text-white">
            <h1 class="text-3xl font-bold mb-4">Welcome to RateFlix, {{ auth()->user()->name }}! 🎬</h1>
            <p class="text-lg opacity-90 leading-relaxed">
                Your personal movie rating platform. Search for movies, rate them, and build your personal collection.
            </p>
        </div>

        <!-- Current Features -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-neutral-200 dark:border-neutral-700 p-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">� Ready to use</h2>
            <div class="grid gap-4 md:grid-cols-2">
                <a href="{{ route('movies') }}" 
                   class="flex items-center gap-4 p-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                    <div class="text-3xl">🔍</div>
                    <div>
                        <h3 class="font-semibold text-blue-900 dark:text-blue-100">Search & Rate Movies</h3>
                        <p class="text-sm text-blue-700 dark:text-blue-300">Find movies and give them ratings</p>
                    </div>
                </a>
                
                <a href="{{ route('ratings') }}" 
                   class="flex items-center gap-4 p-6 bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors">
                    <div class="text-3xl">⭐</div>
                    <div>
                        <h3 class="font-semibold text-purple-900 dark:text-purple-100">Your Ratings</h3>
                        <p class="text-sm text-purple-700 dark:text-purple-300">Manage your movie ratings</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Future Features Preview -->
        <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-xl border border-gray-200 dark:border-gray-700 p-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">� Potential Future Features</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Ideas for expanding the platform:</p>
            
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div class="text-center p-4">
                    <div class="text-2xl mb-2">📊</div>
                    <h3 class="font-medium text-gray-900 dark:text-gray-100 mb-1">Rating Statistics</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">View your rating trends</p>
                </div>
                
                <div class="text-center p-4">
                    <div class="text-2xl mb-2">🏆</div>
                    <h3 class="font-medium text-gray-900 dark:text-gray-100 mb-1">Top Lists</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Community favorites</p>
                </div>
                
                <div class="text-center p-4">
                    <div class="text-2xl mb-2">🎯</div>
                    <h3 class="font-medium text-gray-900 dark:text-gray-100 mb-1">Recommendations</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Personalized suggestions</p>
                </div>
                
                <div class="text-center p-4">
                    <div class="text-2xl mb-2">📋</div>
                    <h3 class="font-medium text-gray-900 dark:text-gray-100 mb-1">Watchlists</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Movies to watch later</p>
                </div>
                
                <div class="text-center p-4">
                    <div class="text-2xl mb-2">👥</div>
                    <h3 class="font-medium text-gray-900 dark:text-gray-100 mb-1">Social Features</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Follow other users</p>
                </div>
                
                <div class="text-center p-4">
                    <div class="text-2xl mb-2">📱</div>
                    <h3 class="font-medium text-gray-900 dark:text-gray-100 mb-1">Mobile App</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Native mobile experience</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
