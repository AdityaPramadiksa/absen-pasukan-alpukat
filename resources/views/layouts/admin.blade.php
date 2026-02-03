<!DOCTYPE html>
<html lang="id">

<head>
    <link rel="manifest" href="/manifest.json">

    <meta name="theme-color" content="#16a34a">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Admin')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        .menu-active {
            background: linear-gradient(90deg, #22c55e, #16a34a);
            color: white;
            box-shadow: 0 10px 25px #22c55e66
        }

        .menu-item {
            transition: .25s
        }

        .menu-item:hover {
            transform: translateX(6px)
        }

        .menu-item:hover i {
            transform: scale(1.15)
        }

        .avatar-ring {
            box-shadow: 0 0 0 3px white, 0 0 0 6px #22c55e55
        }

        .collapsed .sidebar-text {
            display: none
        }

        .brand {
            font-weight: 700;
            font-size: 20px;
            letter-spacing: -.5px
        }
    </style>

</head>

<body class="bg-gray-100">

    <div id="overlay" class="fixed inset-0 bg-black/40 hidden z-30"></div>

    {{-- SIDEBAR --}}
    <aside id="sidebar"
        class="fixed top-0 left-0 h-screen w-64 bg-white border-r z-40 flex flex-col
-translate-x-full md:translate-x-0 transition-all duration-300">

        {{-- BRAND --}}
        <div class="h-16 border-b flex items-center px-5 gap-2">

            <span class="text-2xl">🥑</span>
            <span class="brand sidebar-text">Avocado Lovers</span>

        </div>

        {{-- MENU --}}
        <nav class="flex-1 px-4 py-6 text-sm space-y-6">

            {{-- GENERAL --}}
            <div>
                <p class="text-xs uppercase tracking-wide text-gray-400 mb-2 px-4">
                    General
                </p>

                @php
                    $general = [['Dashboard', 'layout-dashboard', 'admin'], ['Data Staff', 'users', 'admin/staff']];
                @endphp

                @foreach ($general as $m)
                    @php $active = request()->path() === $m[2]; @endphp

                    <a href="/{{ $m[2] }}"
                        class="menu-item flex items-center gap-4 px-4 py-3 rounded-xl
                {{ $active ? 'menu-active' : 'text-gray-600 hover:bg-gray-100' }}">

                        <i data-lucide="{{ $m[1] }}" class="w-5 h-5"></i>
                        <span>{{ $m[0] }}</span>

                    </a>
                @endforeach
            </div>

            {{-- OPERASIONAL --}}
            <div>
                <p class="text-xs uppercase tracking-wide text-gray-400 mb-2 px-4">
                    Operasional
                </p>

                @php
                    $ops = [
                        ['Absensi', 'clipboard-list', 'admin/attendance'],
                        ['Buat Jadwal', 'calendar', 'admin/schedule'],
                        ['Lihat Jadwal', 'grid', 'admin/schedule-matrix'],
                        ['Outlet', 'map-pin', 'admin/outlet'],
                    ];
                @endphp

                @foreach ($ops as $m)
                    @php $active = request()->path() === $m[2]; @endphp

                    <a href="/{{ $m[2] }}"
                        class="menu-item flex items-center gap-4 px-4 py-3 rounded-xl
                {{ $active ? 'menu-active' : 'text-gray-600 hover:bg-gray-100' }}">

                        <i data-lucide="{{ $m[1] }}" class="w-5 h-5"></i>
                        <span>{{ $m[0] }}</span>

                    </a>
                @endforeach
            </div>

            {{-- PAYROLL --}}
            <div>
                <p class="text-xs uppercase tracking-wide text-gray-400 mb-2 px-4">
                    Payroll
                </p>

                @php
                    $payroll = [
                        ['Payroll', 'wallet', 'admin/payroll'],
                        ['Cuti', 'calendar-off', 'admin/leave'],
                        ['Lembur', 'clock', 'admin/overtime'],
                    ];
                @endphp

                @foreach ($payroll as $m)
                    @php $active = request()->path() === $m[2]; @endphp

                    <a href="/{{ $m[2] }}"
                        class="menu-item flex items-center gap-4 px-4 py-3 rounded-xl
                {{ $active ? 'menu-active' : 'text-gray-600 hover:bg-gray-100' }}">

                        <i data-lucide="{{ $m[1] }}" class="w-5 h-5"></i>
                        <span>{{ $m[0] }}</span>

                    </a>
                @endforeach
            </div>

        </nav>


        {{-- USER --}}
        <div class="p-5 border-t">

            <div class="flex items-center gap-4 sidebar-text">

                <div
                    class="avatar-ring w-11 h-11 rounded-xl bg-gradient-to-br from-green-400 to-emerald-600
text-white flex items-center justify-center font-bold">

                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}

                </div>

                <div>
                    <p class="text-xs text-gray-500">Login sebagai</p>
                    <p class="font-semibold">{{ auth()->user()->name }}</p>
                </div>

            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full mt-4 py-2 rounded-xl bg-red-50 text-red-500 hover:bg-red-100 transition">
                    Logout
                </button>
            </form>

        </div>

    </aside>

    {{-- MAIN --}}
    <div id="wrapper" class="ml-0 md:ml-64 transition-all duration-300">

        <header class="h-16 bg-white border-b flex items-center justify-between px-5 sticky top-0 z-20">

            {{-- LEFT --}}
            <div class="flex items-center gap-4">

                <button id="toggle"
                    class="w-10 h-10 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center">
                    <i id="toggleIcon" data-lucide="menu"></i>
                </button>

                <h1 class="font-semibold">@yield('title')</h1>

            </div>

            {{-- RIGHT --}}
            <div class="relative">

                <button id="profileBtn"
                    class="avatar-ring w-9 h-9 rounded-xl bg-gradient-to-br from-green-400 to-emerald-600
text-white flex items-center justify-center">

                    <i data-lucide="user" class="w-4 h-4"></i>

                </button>

                <div id="profileMenu"
                    class="hidden absolute right-0 mt-2 w-44 bg-white rounded-xl shadow border text-sm overflow-hidden">

                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 hover:bg-gray-100">
                        <i data-lucide="settings" class="w-4 h-4"></i>Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="flex items-center gap-2 w-full text-left px-4 py-2 hover:bg-red-50 text-red-500">
                            <i data-lucide="log-out" class="w-4 h-4"></i>Logout
                        </button>
                    </form>

                </div>

            </div>

        </header>


        <main class="p-5 md:p-7">
            @yield('content')
        </main>

    </div>

    <script>
        const profileBtn = document.getElementById('profileBtn')
        const profileMenu = document.getElementById('profileMenu')

        profileBtn.onclick = () => profileMenu.classList.toggle('hidden')

        document.addEventListener('click', e => {
            if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target))
                profileMenu.classList.add('hidden')
        })

        lucide.createIcons()

        const sidebar = document.getElementById('sidebar')
        const wrapper = document.getElementById('wrapper')
        const toggle = document.getElementById('toggle')
        const icon = document.getElementById('toggleIcon')
        const overlay = document.getElementById('overlay')

        let collapsed = localStorage.getItem('sb') === '1'

        function mobile() {
            return window.innerWidth < 768
        }

        function sync() {

            if (mobile()) {
                sidebar.classList.add('-translate-x-full')
                overlay.classList.add('hidden')
                icon.dataset.lucide = 'menu'
                lucide.createIcons()
                return
            }

            if (collapsed) {
                sidebar.classList.replace('w-64', 'w-20')
                sidebar.classList.add('collapsed')
                wrapper.classList.replace('md:ml-64', 'md:ml-20')
                icon.dataset.lucide = 'menu'
            } else {
                sidebar.classList.replace('w-20', 'w-64')
                sidebar.classList.remove('collapsed')
                wrapper.classList.replace('md:ml-20', 'md:ml-64')
                icon.dataset.lucide = 'x'
            }

            lucide.createIcons()
        }

        toggle.onclick = () => {

            if (mobile()) {
                sidebar.classList.toggle('-translate-x-full')
                overlay.classList.toggle('hidden')
                icon.dataset.lucide = sidebar.classList.contains('-translate-x-full') ? 'menu' : 'x'
                lucide.createIcons()
                return
            }

            collapsed = !collapsed
            localStorage.setItem('sb', collapsed ? '1' : '0')
            sync()
        }

        overlay.onclick = () => {
            sidebar.classList.add('-translate-x-full')
            overlay.classList.add('hidden')
            icon.dataset.lucide = 'menu'
            lucide.createIcons()
        }

        window.addEventListener('resize', sync)
        sync()

        if ("serviceWorker" in navigator) {
            navigator.serviceWorker.register("/sw.js");
        }
    </script>

</body>

</html>
