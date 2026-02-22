<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - Avocado Lovers</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body id="page"
    class="bg-gradient-to-b from-[#FBF8EE] to-green-50
    min-h-screen flex items-center justify-center font-sans
    opacity-0 translate-y-4 transition duration-500">

    <div class="w-full max-w-md md:max-w-2xl lg:max-w-5xl px-6 mx-auto">

        {{-- GRID RESPONSIVE --}}
        <div class="lg:grid lg:grid-cols-2 lg:gap-12 lg:items-center lg:justify-center">

            {{-- ================= LEFT SIDE (BRANDING) ================= --}}
            <div class="text-center lg:text-left mb-10 lg:mb-0">

                <div
                    class="mx-auto lg:mx-0 mb-5 w-20 h-20 rounded-3xl bg-green-800 flex items-center justify-center shadow-lg">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h6v6H3V3zm12 0h6v6h-6V3zM3 15h6v6H3v-6zm9 3h3v3h-3v-3zm0-12h3v3h-3V6zm6 6h3v3h-3v-3" />
                    </svg>

                </div>

                <h1 class="text-3xl font-bold text-gray-800">
                    Avocado Lovers
                </h1>

                <p class="text-gray-500 italic mt-1">
                    Freshly picked attendance
                </p>

                {{-- DESKRIPSI KHUSUS DESKTOP --}}
                <p class="hidden lg:block text-gray-500 mt-5 max-w-sm">
                    Sistem absensi dan inventory modern untuk membantu operasional outlet menjadi lebih cepat,
                    rapi, dan profesional.
                </p>

            </div>


            {{-- ================= RIGHT SIDE (FORM LOGIN) ================= --}}
            <div
                class="bg-white/80 backdrop-blur-md
                rounded-3xl shadow-xl border border-white/40
                p-6 lg:p-8">

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- EMAIL --}}
                    <div class="mb-4">
                        <label class="text-sm text-gray-500">EMAIL</label>
                        <input type="email" name="email" required autofocus
                            class="mt-1 w-full rounded-xl border-gray-200
                            focus:border-green-600 focus:ring-green-600">
                    </div>

                    {{-- PASSWORD --}}
                    <div class="mb-5">
                        <label class="text-sm text-gray-500">PASSWORD</label>
                        <input type="password" name="password" required
                            class="mt-1 w-full rounded-xl border-gray-200
                            focus:border-green-600 focus:ring-green-600">
                    </div>

                    {{-- REMEMBER LOGIN --}}
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center gap-2 text-sm text-gray-500">
                            <input type="checkbox" name="remember"
                                class="rounded border-gray-300 text-green-700 focus:ring-green-600">
                            Tetap masuk
                        </label>
                    </div>

                    {{-- BUTTON --}}
                    <button
                        class="w-full py-3 rounded-2xl
                        bg-green-800 text-white font-semibold
                        hover:bg-green-700
                        active:scale-95
                        transition-all duration-200
                        shadow-md">

                        Sign In
                    </button>

                </form>

            </div>

        </div>

        {{-- ================= QR DISPLAY MODE ================= --}}
        <div class="text-center mt-8">
            <a href="/outlet-display" class="text-green-800 font-medium hover:underline">
                Enter Outlet QR Display Mode
            </a>
        </div>

    </div>


    {{-- ================= PAGE TRANSITION SCRIPT ================= --}}
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const page = document.getElementById('page')
            page.classList.remove('opacity-0', 'translate-y-4')
        })
    </script>

</body>

</html>
