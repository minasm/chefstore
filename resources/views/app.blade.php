<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        {{-- Inline style to set the HTML background color based on our theme in app.css --}}
        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }
        </style>

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
        <link rel="icon" href="{{ Vite::asset('resources/assets/favicon.svg') }}" type="image/svg+xml">
        <link rel="apple-touch-icon" href="{{ Vite::asset('resources/assets/apple-touch-icon.png') }}">


        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
    <header class="sr-only xl:not-sr-only">
        <div class="flex flex-wrap justify-between items-center xl:px-32 px-4 py-2">
            <a herf="/">
                <img
                    src="{{ Vite::asset('resources/assets/logo.svg') }}"

                    class="object-contain self-center w-full"
                    alt="Chefstore logo"
                />
            </a>
            <a
                href="https://www.chefstore.nl/"
                class="h-9 px-6 bg-[#e8761c] rounded-full flex justify-start items-center gap-2 min-w-60 font-bold text-white"
                target="_blank"
            >
                <img
                    src="{{ Vite::asset('resources/assets/Reply.svg') }}"
                    class="object-contain w-6 h-6"
                    alt="reply"
                />
                <p>Terug naar Chefstore</p>
            </a>
        </div>

        <div class="flex items-center px-32 w-full bg-[#4c84df] h-14">
            <nav class="flex gap-7 font-semibold text-white text-base">
                <a href="https://www.chefstore.nl/koelingen.html">Koelingen</a>
                <a href="https://www.chefstore.nl/apparatuur-1.html">Apparatuur</a>
                <a href="https://www.chefstore.nl/kooklijnen.html">Kooklijnen</a>
                <a href="https://www.chefstore.nl/rvs.html">RVS</a>
                <a href="https://www.chefstore.nl/bar-en-tafelgerei.html"
                >Bar- en Tafelgerei</a
                >
                <a href="https://www.chefstore.nl/keukengerei.html">Keukengerei</a>
                <a href="https://www.chefstore.nl/horeca-kleding.html">Werkkleding</a>
                <a href="https://www.chefstore.nl/disposables.html">Disposables</a>
                <a href="https://www.chefstore.nl/meubilair.html">Meubilair</a>
                <a href="https://www.chefstore.nl/hygiene.html">Hygiëne</a>
                <a href="https://www.chefstore.nl/onderdelen.html">Onderdelen</a>
                <a href="https://www.chefstore.nl/voor.html">Branches</a>
                <a href="https://www.chefstore.nl/promoties.html">SALE</a>
            </nav>
        </div>
    </header>
        @inertia
    </body>
</html>
