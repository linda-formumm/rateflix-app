@props([
    'rating' => 0,
    'maxStars' => 5,
    'interactive' => false,
    'size' => 'md',
    'showValue' => true,
    'wireModel' => null
])

@php
$sizeClasses = [
    'sm' => 'w-4 h-4',
    'md' => 'w-5 h-5',
    'lg' => 'w-6 h-6',
    'xl' => 'w-8 h-8'
];
$starSize = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<div class="flex items-center gap-1" 
     @if($interactive) 
         x-data="{ 
             currentRating: {{ $rating }}, 
             hoverRating: 0,
             setRating(value) {
                 this.currentRating = value;
                 @if($wireModel) 
                     $wire.set('{{ $wireModel }}', value);
                 @endif
             }
         }" 
     @endif>
    
    @for($i = 1; $i <= $maxStars; $i++)
        @if($interactive)
            <!-- Interactive Star -->
            <button
                type="button"
                @click="setRating({{ $i }})"
                @mouseenter="hoverRating = {{ $i }}"
                @mouseleave="hoverRating = 0"
                class="focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-1 rounded transition-all duration-150 hover:scale-110 cursor-pointer"
                aria-label="Rate {{ $i }} star{{ $i > 1 ? 's' : '' }}">
                
                <svg class="{{ $starSize }} transition-colors duration-150"
                     :class="{
                         'text-yellow-400 fill-current': (hoverRating >= {{ $i }}) || (hoverRating === 0 && currentRating >= {{ $i }}),
                         'text-gray-300 dark:text-gray-600': !((hoverRating >= {{ $i }}) || (hoverRating === 0 && currentRating >= {{ $i }}))
                     }"
                     fill="currentColor" 
                     viewBox="0 0 20 20" 
                     aria-hidden="true">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </button>
        @else
            <!-- Display-Only Star -->
            <svg class="{{ $starSize }} {{ $i <= $rating ? 'text-yellow-400 fill-current' : 'text-gray-300 dark:text-gray-600' }}"
                 fill="currentColor" 
                 viewBox="0 0 20 20" 
                 aria-hidden="true">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
        @endif
    @endfor
    
    @if($showValue && $rating > 0)
        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400 font-medium">
            @if($interactive)
                <span x-text="currentRating + '/{{ $maxStars }}'"></span>
            @else
                {{ $rating }}/{{ $maxStars }}
            @endif
        </span>
    @endif
</div>
