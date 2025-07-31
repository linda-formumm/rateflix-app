@props([
    'rating' => 0,
    'maxStars' => 5,
    'interactive' => false,
    'size' => 'md'
])

@php
$sizeClasses = [
    'sm' => 'w-4 h-4',
    'md' => 'w-5 h-5', 
    'lg' => 'w-6 h-6'
];
$starSize = $sizeClasses[$size] ?? 'w-5 h-5';
@endphp

<div class="flex items-center gap-1">
    @for($i = 1; $i <= $maxStars; $i++)
        <svg class="{{ $starSize }} {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
             fill="currentColor" 
             viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
        </svg>
    @endfor
    
    @if($rating > 0)
        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
            {{ $rating }}/{{ $maxStars }}
        </span>
    @endif
</div>
