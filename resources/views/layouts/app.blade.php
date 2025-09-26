<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EmploiLink') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        
        <!-- Custom LinkedIn-style CSS -->
        <style>
            :root {
                --linkedin-blue: #0a66c2;
                --linkedin-blue-dark: #004182;
                --linkedin-gray: #f3f2ef;
                --linkedin-text: #000000;
                --linkedin-text-secondary: #666666;
                --linkedin-border: #e0dfdc;
            }
            
            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                background-color: var(--linkedin-gray);
                color: var(--linkedin-text);
            }
            
            .linkedin-card {
                background: #ffffff;
                border: 1px solid var(--linkedin-border);
                border-radius: 8px;
                box-shadow: 0 0 0 1px rgba(0,0,0,0.15), 0 1px 2px rgba(0,0,0,0.2);
            }
            
            .linkedin-button {
                background-color: var(--linkedin-blue);
                color: white;
                border: none;
                border-radius: 24px;
                padding: 8px 16px;
                font-weight: 600;
                transition: all 0.2s ease;
            }
            
            .linkedin-button:hover {
                background-color: var(--linkedin-blue-dark);
                transform: translateY(-1px);
            }
            
            .linkedin-button-secondary {
                background-color: transparent;
                color: var(--linkedin-blue);
                border: 1px solid var(--linkedin-blue);
                border-radius: 24px;
                padding: 8px 16px;
                font-weight: 600;
                transition: all 0.2s ease;
            }
            
            .linkedin-button-secondary:hover {
                background-color: rgba(10, 102, 194, 0.1);
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <x-banner />

        <div class="min-h-screen">
            @include('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white/80 dark:bg-gray-900/70 backdrop-blur shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="container mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
        <script>
            // Dark mode toggle support (optional hook)
            document.addEventListener('alpine:init', () => {
                // placeholder for future interactions
            });
        </script>
    </body>
</html>
