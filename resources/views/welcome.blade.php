<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ConnectMe - Real-time Messaging Platform</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
                @layer theme {
                    :root {
                        --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                        --font-serif: ui-serif, Georgia, Cambria, "Times New Roman", Times, serif;
                        --font-mono: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
                    }
                }
            </style>
        @endif
    </head>
    <body class="bg-gray-50 dark:bg-gray-900">
        <div class="min-h-screen">
            <!-- Navigation -->
            @if (Route::has('login'))
                <nav class="fixed w-full bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm z-50">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between h-16">
                            <div class="flex items-center">
                                <h1 class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">ConnectMe</h1>
                            </div>
                            <div class="flex items-center space-x-4">
                                <a href="#about" class="text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">About</a>
                                <a href="{{ route('contact') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Contact</a>
                                @auth
                                    <a href="{{ route('messages.index') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Messages</a>
                                    <form method="POST" action="{{ route('logout') }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                            Log Out
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Log in</a>
                                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Register</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </nav>
            @endif

            <!-- Hero Section -->
            <div class="relative isolate px-6 pt-14 lg:px-8">
                <div class="mx-auto max-w-3xl py-32 sm:py-48 lg:py-56">
                    <div class="text-center">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl">
                            Connect with others in real-time
                        </h1>
                        <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                            Experience seamless communication with our secure and intuitive messaging platform. Stay connected with friends, family, and colleagues.
                        </p>
                        <div class="mt-10 flex items-center justify-center gap-x-6">
                            @auth
                                <a href="{{ route('messages.index') }}" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Go to Messages</a>
                            @else
                                <a href="{{ route('register') }}" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Get Started</a>
                            @endauth
                            <a href="#features" class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-300">Learn more <span aria-hidden="true">→</span></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <div id="features" class="py-24 sm:py-32">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl lg:text-center">
                        <h2 class="text-base font-semibold leading-7 text-indigo-600 dark:text-indigo-400">Communication Made Easy</h2>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">Everything you need to stay connected</p>
                    </div>
                    <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                        <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                            <div class="flex flex-col">
                                <dt class="font-semibold text-gray-900 dark:text-white">
                                    Real-time Messaging
                                </dt>
                                <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600 dark:text-gray-300">
                                    <p>Instant message delivery with real-time updates. No refresh needed.</p>
                                </dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="font-semibold text-gray-900 dark:text-white">
                                    Secure & Private
                                </dt>
                                <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600 dark:text-gray-300">
                                    <p>Your conversations are protected with end-to-end encryption.</p>
                                </dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="font-semibold text-gray-900 dark:text-white">
                                    User Friendly
                                </dt>
                                <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600 dark:text-gray-300">
                                    <p>Clean and intuitive interface for the best messaging experience.</p>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- About Section -->
            <div id="about" class="py-24 sm:py-32 bg-gray-50 dark:bg-gray-800">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl lg:text-center">
                        <h2 class="text-base font-semibold leading-7 text-indigo-600 dark:text-indigo-400">About ConnectMe</h2>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">Our Mission</p>
                        <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                            ConnectMe is designed to make communication seamless and secure. Our platform brings people together through real-time messaging, ensuring your conversations are protected while maintaining an intuitive user experience.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
