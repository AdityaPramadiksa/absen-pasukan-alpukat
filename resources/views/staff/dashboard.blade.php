@extends('layouts.staff')

@section('content')
    {{-- TANGGAL --}}
    <p class="text-sm text-gray-400 dark:text-gray-500 mb-4">
        {{ $todayLabel }}
    </p>

    {{-- STATUS --}}
    <div class="grid grid-cols-2 gap-4 mb-6">

        <div class="bg-green-50 dark:bg-gray-800 rounded-2xl p-4">

            <p class="text-xs text-gray-400 mb-1">STATUS</p>

            <div class="flex items-center gap-2">

                @if ($status == 'HADIR')
                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                @elseif($status == 'TELAT')
                    <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                @elseif($status == 'OFF')
                    <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                @else
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                @endif

                <span class="font-semibold text-sm">
                    {{ $status }}
                </span>

            </div>

        </div>

        <div class="bg-green-50 dark:bg-gray-800 rounded-2xl p-4">

            <p class="text-xs text-gray-400 mb-1">JAM MASUK</p>

            <span class="font-semibold text-sm">
                {{ $checkin }}
            </span>

        </div>

    </div>

    {{-- SCAN --}}
    <a href="{{ route('staff.scan') }}"
        class="block bg-green-800 hover:bg-green-700 text-white rounded-3xl py-10 text-center mb-6 active:scale-95 transition">

        <div class="flex flex-col items-center gap-3">

            <i data-lucide="qr-code" class="w-10 h-10"></i>

            <span class="font-semibold text-lg">
                Scan Absensi QR
            </span>

        </div>

    </a>

    {{-- MENU --}}
    <div class="grid grid-cols-2 gap-4 mb-6">

        {{-- RIWAYAT --}}
        <a href="{{ route('staff.history') }}"
            class="border dark:border-gray-700 rounded-2xl p-4 flex flex-col items-center gap-2
        bg-white dark:bg-gray-900 active:scale-95 transition">

            <i data-lucide="clock" class="w-6 h-6 text-gray-500"></i>

            <span class="text-xs font-medium">Riwayat</span>

        </a>

        {{-- JADWAL --}}
        <a href="{{ route('staff.schedule') }}"
            class="border dark:border-gray-700 rounded-2xl p-4 flex flex-col items-center gap-2
        bg-white dark:bg-gray-900 active:scale-95 transition">

            <i data-lucide="calendar" class="w-6 h-6 text-gray-500"></i>

            <span class="text-xs font-medium">Jadwal</span>

        </a>

        {{-- LEMBUR --}}
        <a href="{{ route('staff.overtime') }}"
            class="border dark:border-gray-700 rounded-2xl p-4 flex flex-col items-center gap-2
        bg-white dark:bg-gray-900 active:scale-95 transition">

            <i data-lucide="clock" class="w-6 h-6 text-gray-500"></i>

            <span class="text-xs font-medium">Lembur</span>

        </a>

        {{-- CUTI STAFF --}}
        @if (auth()->user()->employment_type === 'staff')
            <a href="{{ route('staff.leave') }}"
                class="border dark:border-gray-700 rounded-2xl p-4 flex flex-col items-center gap-2
            bg-white dark:bg-gray-900 active:scale-95 transition">

                <i data-lucide="calendar-off" class="w-6 h-6 text-gray-500"></i>

                <span class="text-xs font-medium">Cuti</span>

            </a>
        @endif

    </div>

    {{-- OUTLET --}}
    <div>

        <h3 class="font-semibold mb-3">
            Informasi Outlet
        </h3>

        <div class="bg-green-50 dark:bg-gray-800 rounded-2xl p-4 flex items-start gap-3">

            <div class="bg-green-200 dark:bg-green-700 p-2 rounded-full">
                <i data-lucide="map-pin" class="w-4 h-4 text-green-700 dark:text-white"></i>
            </div>

            <div>
                <p class="text-sm font-medium">
                    Radius Absensi
                </p>

                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Kamu berada di dalam area cafe
                </p>
            </div>

        </div>

    </div>
@endsection
