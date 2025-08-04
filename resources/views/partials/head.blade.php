<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
{{-- @fluxAppearance --}}

<style>
/* Grid Main Area höherer z-index für Desktop - über Sidebar */
@media (min-width: 1024px) {
    /* Alle möglichen main-Selektoren */
    main,
    [role="main"],
    .main-content,
    .grid-area-main,
    [style*="grid-area: main"],
    [style*="grid-area:main"],
    [class*="grid-area"],
    [class*="main"] {
        z-index: 21 !important;
        position: relative;
    }
    
    /* Spezifische Tailwind-Klassen */
    .\[grid-area\:main\] {
        z-index: 21 !important;
        position: relative;
    }
}

/* Überschreibe Flux Sidebar z-index für Modal-Kompatibilität */
[data-flux-sidebar] {
    z-index: 10 !important;
}
</style>
