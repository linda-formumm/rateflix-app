@props(['count' => 10])

<div class="mt-4 grid gap-4 md:grid-cols-2 lg:grid-cols-3" role="list" aria-label="Loading movie results">
    @for($i = 0; $i < $count; $i++)
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-md overflow-hidden animate-pulse cursor-pointer transform transition-transform duration-200">
            <!-- Skeleton Poster -->
            <div class="w-full h-64 bg-gray-300 dark:bg-zinc-700 relative">
                <!-- Subtle shimmer effect -->
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full animate-[shimmer_2s_infinite]"></div>
            </div>
            
            <!-- Skeleton Content -->
            <div class="p-4">
                <!-- Title skeleton - varied widths for realism -->
                <div class="h-5 bg-gray-300 dark:bg-zinc-700 rounded mb-2 relative overflow-hidden"
                     style="width: {{ collect([100, 85, 95, 75, 90])->random() }}%">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full animate-[shimmer_2s_infinite]" style="animation-delay: 0.2s"></div>
                </div>
                <div class="h-4 bg-gray-300 dark:bg-zinc-700 rounded mb-2 relative overflow-hidden"
                     style="width: {{ collect([60, 45, 70, 55])->random() }}%">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full animate-[shimmer_2s_infinite]" style="animation-delay: 0.4s"></div>
                </div>
                
                <!-- Year skeleton -->
                <div class="h-3 bg-gray-300 dark:bg-zinc-700 rounded w-1/4 mb-3 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full animate-[shimmer_2s_infinite]" style="animation-delay: 0.6s"></div>
                </div>
                
                <!-- Type skeleton -->
                <div class="h-3 bg-gray-300 dark:bg-zinc-700 rounded w-1/3 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full animate-[shimmer_2s_infinite]" style="animation-delay: 0.8s"></div>
                </div>
            </div>
        </div>
    @endfor
</div>

<style>
@keyframes shimmer {
    0% {
        transform: translateX(-100%);
    }
    100% {
        transform: translateX(100%);
    }
}
</style>
