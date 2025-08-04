<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? config('app.name') }}</title>
    
    <style>
        /* Basic styles for testing */
        body { 
            font-family: system-ui, -apple-system, sans-serif; 
            margin: 0; 
            padding: 0; 
            background: #f9fafb;
        }
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 1rem; 
        }
        .btn { 
            display: inline-block;
            padding: 0.5rem 1rem; 
            border: 1px solid #d1d5db; 
            border-radius: 0.375rem;
            background: white;
            text-decoration: none;
            color: #374151;
        }
        .btn:hover {
            background: #f3f4f6;
        }
        .text-center { text-align: center; }
        .hidden { display: none; }
        .grid { display: grid; }
        .space-y-4 > * + * { margin-top: 1rem; }
        .text-xl { font-size: 1.25rem; }
        .font-bold { font-weight: 700; }
    </style>
</head>
<body>
    {{ $slot }}
</body>
</html>
