@extends('layouts.staff')

@section('content')
    {{-- ================= HEADER DATE ================= --}}
    <p class="text-xs tracking-wide text-gray-400 dark:text-gray-500 mb-5">
        {{ $todayLabel }}
    </p>


    {{-- ================= STATUS CARD ================= --}}
    <div class="grid grid-cols-2 gap-4 mb-7">

        <div class="bg-white dark:bg-gray-900 rounded-3xl p-5 shadow-sm border border-gray-100 dark:border-gray-800">

            <p class="text-[10px] tracking-wide text-gray-400 mb-2">
                STATUS
            </p>

            <div class="flex items-center gap-2">

                @if ($status == 'HADIR')
                    <span class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></span>
                @elseif($status == 'TELAT')
                    <span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span>
                @elseif($status == 'OFF')
                    <span class="w-2.5 h-2.5 rounded-full bg-gray-400"></span>
                @else
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                @endif

                <span class="font-semibold text-sm text-gray-800 dark:text-white">
                    {{ $status }}
                </span>

            </div>

        </div>


        <div class="bg-white dark:bg-gray-900 rounded-3xl p-5 shadow-sm border border-gray-100 dark:border-gray-800">

            <p class="text-[10px] tracking-wide text-gray-400 mb-2">
                JAM MASUK
            </p>

            <span class="font-semibold text-sm text-gray-800 dark:text-white">
                {{ $checkin }}
            </span>

        </div>

    </div>


    {{-- ================= HERO SCAN ================= --}}
    <a href="{{ route('staff.scan') }}"
        class="relative block rounded-[28px] overflow-hidden mb-7
        bg-gradient-to-br from-green-700 via-green-800 to-green-900
        text-white py-12 text-center
        shadow-lg active:scale-[0.97] transition-all duration-200">

        <div class="absolute inset-0 opacity-10">
            <div class="w-full h-full bg-[radial-gradient(circle_at_top_left,white,transparent_60%)]"></div>
        </div>

        <div class="relative flex flex-col items-center gap-3">

            <div class="bg-white/10 backdrop-blur-md p-4 rounded-full">
                <i data-lucide="qr-code" class="w-10 h-10"></i>
            </div>

            <span class="font-semibold text-lg tracking-wide">
                Scan Absensi QR
            </span>

            <span class="text-[11px] text-green-200">
                Tap untuk melakukan absensi masuk
            </span>

        </div>

    </a>


    {{-- ================= MENU GRID ================= --}}
    <div class="grid grid-cols-2 gap-4 mb-7">

        {{-- INVENTORY --}}
        <a href="{{ route('staff.inventory') }}"
            class="group bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800
            rounded-3xl p-5 flex flex-col items-center gap-3
            shadow-sm hover:shadow-md transition-all">

            <span
                class="p-3 rounded-full bg-green-100 text-green-700
                dark:bg-green-900/30 dark:text-green-300
                group-hover:scale-110 transition">
                <i data-lucide="package" class="w-5 h-5"></i>
            </span>

            <span class="text-xs font-medium text-gray-700 dark:text-gray-200">
                Inventory
            </span>

        </a>


        {{-- RIWAYAT --}}
        <a href="{{ route('staff.history') }}"
            class="group bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800
            rounded-3xl p-5 flex flex-col items-center gap-3
            shadow-sm hover:shadow-md transition-all">

            <span
                class="p-3 rounded-full bg-blue-100 text-blue-700
                dark:bg-blue-900/30 dark:text-blue-300
                group-hover:scale-110 transition">
                <i data-lucide="clock" class="w-5 h-5"></i>
            </span>

            <span class="text-xs font-medium text-gray-700 dark:text-gray-200">
                Riwayat
            </span>

        </a>


        {{-- JADWAL --}}
        <a href="{{ route('staff.schedule') }}"
            class="group bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800
            rounded-3xl p-5 flex flex-col items-center gap-3
            shadow-sm hover:shadow-md transition-all">

            <span
                class="p-3 rounded-full bg-purple-100 text-purple-700
                dark:bg-purple-900/30 dark:text-purple-300
                group-hover:scale-110 transition">
                <i data-lucide="calendar" class="w-5 h-5"></i>
            </span>

            <span class="text-xs font-medium text-gray-700 dark:text-gray-200">
                Jadwal
            </span>

        </a>


        {{-- LEMBUR --}}
        <a href="{{ route('staff.overtime') }}"
            class="group bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800
            rounded-3xl p-5 flex flex-col items-center gap-3
            shadow-sm hover:shadow-md transition-all">

            <span
                class="p-3 rounded-full bg-orange-100 text-orange-700
                dark:bg-orange-900/30 dark:text-orange-300
                group-hover:scale-110 transition">
                <i data-lucide="timer" class="w-6 h-6 text-gray-500"></i>
            </span>

            <span class="text-xs font-medium text-gray-700 dark:text-gray-200">
                Lembur
            </span>

        </a>


        {{-- CUTI --}}
        @if (auth()->user()->employment_type === 'staff')
            <a href="{{ route('staff.leave') }}"
                class="group bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800
                rounded-3xl p-5 flex flex-col items-center gap-3
                shadow-sm hover:shadow-md transition-all">

                <span
                    class="p-3 rounded-full bg-red-100 text-red-700
                    dark:bg-red-900/30 dark:text-red-300
                    group-hover:scale-110 transition">
                    <i data-lucide="calendar-off" class="w-5 h-5"></i>
                </span>

                <span class="text-xs font-medium text-gray-700 dark:text-gray-200">
                    Cuti
                </span>

            </a>
        @endif

    </div>


    {{-- ================= OUTLET INFO ================= --}}
    <div>

        <h3 class="font-semibold mb-3 text-gray-800 dark:text-white">
            Informasi Outlet
        </h3>

        <div
            class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800
        rounded-3xl p-5 flex items-start gap-3 shadow-sm">

            <div class="bg-green-100 dark:bg-green-900/40 p-3 rounded-full">
                <i data-lucide="map-pin" class="w-4 h-4 text-green-700 dark:text-green-300"></i>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-800 dark:text-white">
                    Radius Absensi
                </p>

                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Kamu berada di dalam area cafe
                </p>
            </div>

        </div>

    </div>


    <script>
        lucide.createIcons()
    </script>
@endsection
