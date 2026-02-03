<!DOCTYPE html>
<html lang="id">

<head>
    <link rel="manifest" href="/manifest.json">

    <meta name="theme-color" content="#16a34a">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Staff</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gray-50 dark:bg-gray-900 dark:text-gray-100 transition-all duration-300">

    <main class="max-w-md mx-auto min-h-screen p-5 pb-24">

        {{-- HEADER --}}
        <div class="flex items-start justify-between mb-6">

            <div>
                <h1 class="text-xl font-bold">
                    Halo, {{ auth()->user()->name }}
                </h1>

                <p class="text-gray-500 dark:text-gray-400 text-sm capitalize">
                    {{ auth()->user()->employment_type ?? 'staff' }} · Avocado Lovers
                </p>
            </div>

            <div class="flex items-center gap-3">

                {{-- DARK MODE TOGGLE --}}
                <button id="darkToggle" class="w-12 h-6 rounded-full bg-gray-200 dark:bg-gray-700 relative transition">

                    <span id="toggleDot"
                        class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full flex items-center justify-center transition">

                        {{-- SUN --}}
                        <i id="sunIcon" data-lucide="sun" class="w-3 h-3 text-yellow-500"></i>

                        {{-- MOON --}}
                        <i id="moonIcon" data-lucide="moon" class="w-3 h-3 text-gray-500"></i>

                    </span>
                </button>

                {{-- LOGOUT --}}
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                    class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                </a>

            </div>

        </div>

        {{-- PAGE CONTENT --}}
        @yield('content')

    </main>

    {{-- BOTTOM NAV --}}
    <nav class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-900 border-t dark:border-gray-800">

        <div class="max-w-md mx-auto px-6 h-16 flex items-center justify-between">

            {{-- HOME --}}
            <a href="{{ route('staff.dashboard') }}"
                class="flex flex-col items-center text-[11px]
                {{ request()->routeIs('staff.dashboard') ? 'text-green-600' : 'text-gray-400' }}">
                <i data-lucide="home" class="w-5 h-5 mb-1"></i>
                Home
            </a>

            {{-- PAYROLL --}}
            <a href="{{ route('staff.payroll') }}"
                class="flex flex-col items-center text-[11px]
                {{ request()->routeIs('staff.payroll') ? 'text-green-600' : 'text-gray-400' }}">
                <i data-lucide="wallet" class="w-5 h-5 mb-1"></i>
                Gaji
            </a>

            {{-- PROFILE --}}
            <a href="{{ route('staff.profile') }}"
                class="flex flex-col items-center text-[11px]
                {{ request()->routeIs('staff.profile') ? 'text-green-600' : 'text-gray-400' }}">
                <i data-lucide="user" class="w-5 h-5 mb-1"></i>
                Profil
            </a>

        </div>

    </nav>

    {{-- LOGOUT FORM --}}
    <form id="logout-form" method="POST" action="{{ route('logout') }}">
        @csrf
    </form>

    {{-- SCRIPT --}}
    <script>
        lucide.createIcons();

        // SERVICE WORKER
        if ("serviceWorker" in navigator) {
            navigator.serviceWorker.register("/sw.js");
        }

        lucide.createIcons()

        const toggle = document.getElementById('darkToggle')
        const html = document.documentElement
        const dot = document.getElementById('toggleDot')
        const sun = document.getElementById('sunIcon')
        const moon = document.getElementById('moonIcon')

        function setTheme(isDark) {

            if (isDark) {
                html.classList.add('dark')
                dot.classList.add('translate-x-6')
                sun.classList.add('hidden')
                moon.classList.remove('hidden')
            } else {
                html.classList.remove('dark')
                dot.classList.remove('translate-x-6')
                moon.classList.add('hidden')
                sun.classList.remove('hidden')
            }

            localStorage.setItem('dark', isDark)
        }

        // init
        setTheme(localStorage.getItem('dark') === 'true')

        toggle.addEventListener('click', () => {
            setTheme(!html.classList.contains('dark'))
        })
    </script>


</body>

</html>
