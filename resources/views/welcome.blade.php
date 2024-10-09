<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Notes - Collaborative Note-taking App</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            body {
                font-family: 'Figtree', sans-serif;
                background-color: #f8fafc;
                color: #1a202c;
            }
            .flex {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                text-align: center;
            }
            .title {
                font-size: 4rem;
                font-weight: 600;
                margin-bottom: 1.5rem;
            }
            .subtitle {
                font-size: 1.25rem;
                margin-bottom: 2rem;
            }
            .cta-buttons {
                display: flex;
                gap: 1rem;
                justify-content: center;
            }
            .cta-buttons a {
                text-decoration: none;
                padding: 0.75rem 1.5rem;
                border-radius: 0.375rem;
                background-color: #4f46e5;
                color: white;
                font-weight: 600;
                transition: background-color 0.3s ease;
            }
            .cta-buttons a:hover {
                background-color: #4338ca;
            }
        </style>
    </head>
    <body>
        <div class="flex">
            <div>
                <h1 class="title">Welcome to Notes</h1>
                <p class="subtitle">Your go-to platform for real-time collaborative note-taking.</p>
                <div class="cta-buttons">
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Get Started</a>
                </div>
                <p class="mt-6 text-sm text-gray-500">
                    Join us today and experience seamless note-taking, whether for personal use or group collaboration. 
                    Save, edit, and share your notes in real-time.
                </p>
            </div>
        </div>
    </body>
</html>
