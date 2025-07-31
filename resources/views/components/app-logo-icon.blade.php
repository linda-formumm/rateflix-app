<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 220 45" {{ $attributes }}>
    <!-- RATEFLIX text in Netflix style with bottom curve - red text on transparent background -->
    <defs>
        <!-- Separate Masken für R und X mit subtileren Krümmungen -->
        <mask id="maskR">
            <rect x="0" y="0" width="25" height="45" fill="white"/>
            <!-- Kleinere Ellipse für R - subtile rechte untere Krümmung -->
            <ellipse cx="18" cy="41" rx="6" ry="3" fill="black"/>
        </mask>
        
        <mask id="maskX">
            <rect x="0" y="0" width="22" height="45" fill="white"/>
            <!-- Kleinere Ellipse für X - subtile linke untere Krümmung -->
            <ellipse cx="4" cy="40" rx="6" ry="4" fill="black"/>
        </mask>
    </defs>
    
    <g fill="#E50914" class="fill-red-600">
        <!-- R - längster Buchstabe mit eigener Maske -->
        <g transform="translate(8,0)" mask="url(#maskR)">
            <path d="M0,0 L0,40 L7,40 L7,24 L12,24 C15,24 17,22 17,19 L17,5 C17,2 15,0 12,0 L0,0 Z M7,5 L12,5 L12,19 L7,19 L7,5 Z"/>
            <path d="M9,24 L16,40 L23,40 L13,24"/>
        </g>
        
        <!-- A -->
        <g transform="translate(38,0)">
            <polygon points="0,35 6,35 8.5,5 12.5,5 15,35 21,35 17,0 4,0"/>
            <rect x="6" y="20" width="9" height="5"/>
        </g>
        
        <!-- T -->
        <g transform="translate(65,0)">
            <rect x="0" y="0" width="22" height="5"/>
            <rect x="8" y="0" width="6" height="32"/>
        </g>
        
        <!-- E -->
        <g transform="translate(92,0)">
            <path d="M0,0 L0,32 L21,32 L21,27 L6,27 L6,19 L19,19 L19,14 L6,14 L6,5 L21,5 L21,0 L0,0 Z"/>
        </g>
        
        <!-- F -->
        <g transform="translate(118,0)">
            <path d="M0,0 L0,32 L6,32 L6,19 L19,19 L19,14 L6,14 L6,5 L21,5 L21,0 L0,0 Z"/>
        </g>
        
        <!-- L -->
        <g transform="translate(144,0)">
            <path d="M0,0 L0,35 L21,35 L21,30 L6,30 L6,0 L0,0 Z"/>
        </g>
        
        <!-- I -->
        <g transform="translate(170,0)">
            <rect x="0" y="0" width="6" height="35"/>
        </g>
        
        <!-- X - längster Buchstabe mit eigener Maske -->
        <g transform="translate(183,0)" mask="url(#maskX)">
            <path d="M0,0 L7,16 L0,40 L6,40 L10,26 L14,40 L20,40 L13,16 L20,0 L14,0 L10,13 L6,0 L0,0 Z"/>
        </g>
    </g>
</svg>
