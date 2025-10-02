<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')

    <title>{{ config('APP.NAME', 'DAMOCLES') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

</head>

<body class="flex flex-col justify-between font-sans antialiased min-h-screen bg-sky-100 text-sky-900">

    <header class="flex flex-col sm:flex-row items-center justify-between py-2 shadow bg-white h-20 sm:h-16">

        <p class="px-3 text-2xl font-extrabold">DAMOCLES</p>

        @if (Route::has('login'))
            <nav class="flex flex-1 justify-end">
                @auth
                    @if (auth()->user()->role === 'User')
                        <a href="{{ route('questionnaires-campaign.index') }}"
                            class="rounded-md px-3 py-2 ring-1 ring-transparent transition hover:text-sky/70 focus:outline-none">
                            Questionnaire campaigns
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}"
                            class="rounded-md px-3 py-2 ring-1 ring-transparent transition hover:text-sky/70 focus:outline-none">
                            Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                        class="rounded-md px-3 py-2 ring-1 ring-transparent transition hover:text-sky/70 focus:outline-none">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="rounded-md px-3 py-2 ring-1 ring-transparent transition hover:text-sky/70 focus:outline-none">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <main class="flex flex-col items-center justify-center h-32">
        <!-- Content -->

    </main>

    <footer class="py-2 text-center text-sm">
        Credits: Daniele Semeraro 
        <br> Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        <br> Project version: {{ git_version() }}
    </footer>
</body>

</html>
