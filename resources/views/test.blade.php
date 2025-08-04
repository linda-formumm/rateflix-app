<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="min-h-screen bg-gray-50 flex items-center justify-center">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-4">RateFlix Test</h1>
            <p class="text-gray-600">Laravel läuft erfolgreich!</p>
            <p class="text-sm text-gray-500 mt-2">Vite Assets: {{ Vite::asset('resources/css/app.css') ? 'Gefunden' : 'Nicht gefunden' }}</p>
        </div>
    </div>
</body>
</html>
