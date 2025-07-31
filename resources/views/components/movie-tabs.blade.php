@props(['activeTab' => 'details'])

<div class="border-b border-gray-200 dark:border-gray-600 mb-4">
    <nav class="-mb-px flex space-x-8">
        <!-- Details Tab -->
        <button
            x-data="{ active: @entangle('activeTab') }"
            x-on:click="$wire.set('activeTab', 'details')"
            :class="active === 'details' 
                ? 'border-blue-500 text-blue-600 dark:text-blue-400' 
                : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300'"
            class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
            Movie Details
        </button>
        
        <!-- Community Ratings Tab -->
        <button
            x-data="{ active: @entangle('activeTab') }"
            x-on:click="$wire.set('activeTab', 'ratings')"
            :class="active === 'ratings' 
                ? 'border-blue-500 text-blue-600 dark:text-blue-400' 
                : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300'"
            class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
            Community Ratings
        </button>
    </nav>
</div>
