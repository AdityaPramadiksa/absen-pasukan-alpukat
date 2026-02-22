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

    <style>
        @keyframes splashUp {
            from {
                transform: scale(.9);
                opacity: 0
            }

            to {
                transform: scale(1);
                opacity: 1
            }
        }

        @keyframes loader {
            from {
                width: 0
            }

            to {
                width: 100%
            }
        }

        .animate-splash {
            animation: splashUp .4s ease;
        }

        .animate-loader {
            animation: loader 1.2s linear infinite;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 dark:text-gray-100 transition-all duration-300">

    <!-- ================= SPLASH (LIGHTWEIGHT) ================= -->
    <div id="splash"
        class="fixed inset-0 z-[999] flex flex-col items-center justify-center
bg-gradient-to-b from-green-900 to-green-800 text-white">

        <div class="flex flex-col items-center gap-4 animate-splash">

            <div
                class="w-20 h-20 rounded-3xl bg-white/10 backdrop-blur-md
        flex items-center justify-center shadow-xl">
                <i data-lucide="leaf" class="w-10 h-10"></i>
            </div>

            <h1 class="text-lg font-semibold tracking-wide">
                Avocado Lovers
            </h1>

            <div class="w-20 h-1 bg-white/20 rounded-full overflow-hidden">
                <div class="h-full bg-white animate-loader"></div>
            </div>

        </div>
    </div>

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
                        class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full
                    flex items-center justify-center transition">

                        <i id="sunIcon" data-lucide="sun" class="w-3 h-3 text-yellow-500"></i>
                        <i id="moonIcon" data-lucide="moon" class="w-3 h-3 text-gray-500 hidden"></i>

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

        {{-- CONTENT --}}
        @yield('content')

    </main>

    {{-- ================= BOTTOM NAV ================= --}}
    <nav class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-900 border-t dark:border-gray-800">

        <div class="max-w-md mx-auto px-6 h-16 flex items-center justify-between">

            <a href="{{ route('staff.dashboard') }}"
                class="flex flex-col items-center text-[11px]
            {{ request()->routeIs('staff.dashboard') ? 'text-green-600' : 'text-gray-400' }}">
                <i data-lucide="home" class="w-5 h-5 mb-1"></i>
                Home
            </a>

            <a href="{{ route('staff.payroll') }}"
                class="flex flex-col items-center text-[11px]
            {{ request()->routeIs('staff.payroll') ? 'text-green-600' : 'text-gray-400' }}">
                <i data-lucide="wallet" class="w-5 h-5 mb-1"></i>
                Gaji
            </a>

            <a href="{{ route('staff.profile') }}"
                class="flex flex-col items-center text-[11px]
            {{ request()->routeIs('staff.profile') ? 'text-green-600' : 'text-gray-400' }}">
                <i data-lucide="user" class="w-5 h-5 mb-1"></i>
                Profil
            </a>

        </div>

    </nav>

    <form id="logout-form" method="POST" action="{{ route('logout') }}">
        @csrf
    </form>

    {{-- ================= SCRIPT ================= --}}
    <script>
        lucide.createIcons()

        // SERVICE WORKER (PWA)
        if ("serviceWorker" in navigator) {
            navigator.serviceWorker.register("/sw.js")
        }

        // ================= DARK MODE =================
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

        setTheme(localStorage.getItem('dark') === 'true')

        toggle.addEventListener('click', () => {
            setTheme(!html.classList.contains('dark'))
        })

        // ================= SPLASH LIGHTWEIGHT =================
        window.addEventListener("load", () => {

            const splash = document.getElementById("splash")

            // tampil sekali saja (ringan untuk cafe system)
            if (sessionStorage.getItem("app_loaded")) {
                splash.remove()
                return
            }

            sessionStorage.setItem("app_loaded", true)

            setTimeout(() => {
                splash.style.transition = "all .5s ease"
                splash.style.opacity = "0"
                splash.style.transform = "scale(1.05)"

                setTimeout(() => splash.remove(), 500)

            }, 700)

        })
    </script>

</body>

</html>
