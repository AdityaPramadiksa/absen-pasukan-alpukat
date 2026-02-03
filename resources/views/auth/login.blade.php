<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - Avocado Lovers</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FBF8EE] min-h-screen flex items-center justify-center font-sans">

    <div class="w-full max-w-md px-6">

        {{-- LOGO --}}
        <div class="text-center mb-8">

            <div class="mx-auto mb-4 w-20 h-20 rounded-2xl bg-green-800 flex items-center justify-center">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h6v6H3V3zm12 0h6v6h-6V3zM3 15h6v6H3v-6zm9 3h3v3h-3v-3zm0-12h3v3h-3V6zm6 6h3v3h-3v-3z" />
                </svg>

            </div>

            <h1 class="text-2xl font-bold">Avocado Lovers</h1>
            <p class="text-gray-500 italic">Freshly picked attendance</p>

        </div>

        {{-- FORM --}}
        <div class="bg-white rounded-2xl shadow p-6">

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label class="text-sm text-gray-500">EMAIL</label>
                    <input type="email" name="email" required autofocus
                        class="mt-1 w-full rounded-xl border-gray-200 focus:border-green-600 focus:ring-green-600">
                </div>

                <div class="mb-6">
                    <label class="text-sm text-gray-500">PASSWORD</label>
                    <input type="password" name="password" required
                        class="mt-1 w-full rounded-xl border-gray-200 focus:border-green-600 focus:ring-green-600">
                </div>

                <button
                    class="w-full py-3 rounded-xl bg-green-800 text-white font-semibold hover:bg-green-700 transition">
                    Sign In
                </button>

            </form>

        </div>

        {{-- QR DISPLAY MODE --}}
        <div class="text-center mt-6">
            <a href="/outlet-display" class="text-green-800 font-medium hover:underline">
                Enter Outlet QR Display Mode
            </a>
        </div>

    </div>

</body>

</html>
