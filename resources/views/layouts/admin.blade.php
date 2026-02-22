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
        /* ================= ULTRA PREMIUM STYLE ================= */

        body {
            opacity: 0;
            transform: translateY(6px);
            transition: .25s ease;
        }

        body.page-loaded {
            opacity: 1;
            transform: none;
        }

        /* GLASS SIDEBAR */
        #sidebar {
            background: rgba(255, 255, 255, .85);
            backdrop-filter: blur(18px);
            border-right: 1px solid #f1f5f9;
        }

        /* HEADER DEPTH */
        header {
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 12px rgba(0, 0, 0, .04);
        }

        /* MENU */
        .menu-item {
            transition: .25s;
            border: 1px solid transparent;
        }

        .menu-item:hover {
            transform: translateX(6px);
            background: #f0fdf4;
            border-color: #22c55e22;
        }

        .menu-item i {
            transition: .25s;
        }

        .menu-item:hover i {
            transform: scale(1.15);
        }

        .menu-active {
            background: linear-gradient(90deg, #22c55e, #16a34a);
            color: white;
            box-shadow: 0 8px 20px #22c55e33;
        }

        /* AVATAR */
        .avatar-ring {
            box-shadow:
                0 0 0 3px white,
                0 0 0 6px #22c55e33,
                0 10px 25px #22c55e22;
        }

        /* COLLAPSE */
        .collapsed .sidebar-text,
        .collapsed .sidebar-section {
            display: none;
        }

        .collapsed .menu-item {
            justify-content: center;
        }

        .brand {
            font-weight: 700;
            font-size: 20px;
        }
    </style>

</head>

<body class="bg-gray-100">

    <div id="overlay" class="fixed inset-0 bg-black/40 hidden z-30"></div>

    <!-- ================= SIDEBAR ================= -->
    <aside id="sidebar"
        class="fixed top-0 left-0 h-screen w-64 z-40 flex flex-col
-translate-x-full md:translate-x-0 transition-all duration-300">

        <div class="h-16 border-b flex items-center px-5 gap-2">
            <span class="text-2xl">🥑</span>
            <span class="brand sidebar-text">Avocado Lovers</span>
        </div>

        <nav class="flex-1 overflow-y-auto px-4 py-6 text-sm space-y-6">

            @php
                $general = [['Dashboard', 'layout-dashboard', 'admin'], ['Data Staff', 'users', 'admin/staff']];
                $ops = [
                    ['Absensi', 'clipboard-list', 'admin/attendance'],
                    ['Buat Jadwal', 'calendar', 'admin/schedule'],
                    ['Lihat Jadwal', 'grid', 'admin/schedule-matrix'],
                    ['Outlet', 'map-pin', 'admin/outlet'],
                ];
                $payroll = [
                    ['Payroll', 'wallet', 'admin/payroll'],
                    ['Cuti', 'calendar-off', 'admin/leave'],
                    ['Lembur', 'timer', 'admin/overtime'],
                ];
                $inventory = [['Supplier', 'truck', 'admin/suppliers'], ['History', 'history', 'admin/history']];
            @endphp

            @foreach ([['General', $general], ['Operasional', $ops], ['Payroll', $payroll], ['Inventory', $inventory]] as $group)
                <div>
                    <p class="sidebar-section text-xs uppercase tracking-wide text-gray-400 mb-2 px-4">
                        {{ $group[0] }}</p>

                    @foreach ($group[1] as $m)
                        @php $active=request()->path()===$m[2]; @endphp

                        <a href="/{{ $m[2] }}"
                            class="menu-item flex items-center gap-4 px-4 py-3 rounded-xl
{{ $active ? 'menu-active' : 'text-gray-600' }}">

                            <i data-lucide="{{ $m[1] }}" class="w-5 h-5"></i>
                            <span class="sidebar-text whitespace-nowrap">{{ $m[0] }}</span>

                        </a>
                    @endforeach
                </div>
            @endforeach

        </nav>

        <!-- USER -->
        <div class="p-5 border-t">

            <div class="flex items-center gap-4 sidebar-text">

                <div
                    class="avatar-ring w-11 h-11 rounded-xl
bg-gradient-to-br from-green-400 to-emerald-600
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

    <!-- ================= MAIN ================= -->
    <div id="wrapper" class="ml-0 md:ml-64 transition-all duration-300">

        <header class="h-16 bg-white flex items-center justify-between px-5 sticky top-0 z-20">

            <div class="flex items-center gap-4">

                <button id="toggle"
                    class="w-10 h-10 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center">
                    <i id="toggleIcon" data-lucide="menu"></i>
                </button>

                <h1 class="font-semibold">@yield('title')</h1>

            </div>

            <div class="relative">

                <button id="profileBtn"
                    class="avatar-ring w-9 h-9 rounded-xl
bg-gradient-to-br from-green-400 to-emerald-600
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
        /* PAGE TRANSITION */
        window.addEventListener("DOMContentLoaded", () => {
            document.body.classList.add("page-loaded")
        })

        lucide.createIcons()

        /* PROFILE DROPDOWN */
        const profileBtn = document.getElementById('profileBtn')
        const profileMenu = document.getElementById('profileMenu')

        profileBtn.onclick = () => profileMenu.classList.toggle('hidden')

        document.addEventListener('click', e => {
            if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                profileMenu.classList.add('hidden')
            }
        })

        /* SIDEBAR SYSTEM */
        const sidebar = document.getElementById('sidebar')
        const wrapper = document.getElementById('wrapper')
        const toggle = document.getElementById('toggle')
        const icon = document.getElementById('toggleIcon')
        const overlay = document.getElementById('overlay')

        let collapsed = localStorage.getItem('sb') === '1'

        function isMobile() {
            return window.innerWidth < 768
        }

        function syncSidebar() {

            if (isMobile()) {
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

            if (isMobile()) {
                sidebar.classList.toggle('-translate-x-full')
                overlay.classList.toggle('hidden')
                icon.dataset.lucide = sidebar.classList.contains('-translate-x-full') ? 'menu' : 'x'
                lucide.createIcons()
                return
            }

            collapsed = !collapsed
            localStorage.setItem('sb', collapsed ? '1' : '0')
            syncSidebar()
        }

        overlay.onclick = () => {
            sidebar.classList.add('-translate-x-full')
            overlay.classList.add('hidden')
            icon.dataset.lucide = 'menu'
            lucide.createIcons()
        }

        window.addEventListener('resize', syncSidebar)
        syncSidebar()

        /* PWA */
        if ("serviceWorker" in navigator) {
            navigator.serviceWorker.register("/sw.js")
        }
    </script>

</body>

</html>
