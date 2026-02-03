@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <h1 class="text-3xl font-bold mb-2">Dashboard</h1>
    <p class="text-gray-500 mb-6">Ringkasan aktivitas hari ini</p>

    {{-- STATS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-5 mb-8">

        <div class="bg-white rounded-xl p-4 md:p-5 shadow">
            <p class="text-xs md:text-sm text-gray-400">Dijadwalkan Hari Ini</p>
            <p class="text-2xl md:text-3xl font-bold">{{ $totalScheduled }}</p>
        </div>

        <div class="bg-white rounded-xl p-4 md:p-5 shadow">
            <p class="text-xs md:text-sm text-gray-400">Sudah Hadir</p>
            <p class="text-2xl md:text-3xl font-bold text-green-600">{{ $hadir }}</p>
        </div>

        <div class="bg-white rounded-xl p-4 md:p-5 shadow">
            <p class="text-xs md:text-sm text-gray-400">Telat</p>
            <p class="text-2xl md:text-3xl font-bold text-red-500">{{ $telat }}</p>
        </div>

        <div class="bg-white rounded-xl p-4 md:p-5 shadow">
            <p class="text-xs md:text-sm text-gray-400">Belum Absen</p>
            <p class="text-2xl md:text-3xl font-bold text-orange-500">{{ $belumAbsen }}</p>
        </div>

    </div>

    {{-- RECENT --}}
    <div class="bg-white rounded-xl shadow p-5 md:p-6">

        <h2 class="font-semibold mb-4">Absensi Terbaru Hari Ini</h2>

        @if ($recent->count())

            {{-- DESKTOP --}}
            <div class="hidden md:block space-y-3">

                @foreach ($recent as $r)
                    <div class="flex justify-between items-center border rounded-xl p-3">

                        <div>
                            <p class="font-medium">{{ $r->name }}</p>
                            <p class="text-xs text-gray-400">Shift {{ $r->code }}</p>
                        </div>

                        <div class="text-right">

                            <p class="text-sm font-semibold">
                                {{ \Carbon\Carbon::parse($r->checkin_time)->format('H:i') }}
                            </p>

                            @if ($r->status == 'ontime')
                                <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-600">On Time</span>
                            @else
                                <span class="text-xs px-2 py-1 rounded-full bg-red-100 text-red-600">Telat</span>
                            @endif

                        </div>

                    </div>
                @endforeach

            </div>

            {{-- MOBILE --}}
            <div class="md:hidden divide-y">

                @foreach ($recent as $r)
                    <div class="py-3 space-y-1">

                        <div class="flex justify-between">

                            <p class="font-semibold">{{ $r->name }}</p>

                            @if ($r->status == 'ontime')
                                <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-600">On Time</span>
                            @else
                                <span class="text-xs px-2 py-1 rounded-full bg-red-100 text-red-600">Telat</span>
                            @endif

                        </div>

                        <p class="text-xs text-gray-400">
                            Shift {{ $r->code }}
                        </p>

                        <p class="text-sm font-medium">
                            Jam {{ \Carbon\Carbon::parse($r->checkin_time)->format('H:i') }}
                        </p>

                    </div>
                @endforeach

            </div>
        @else
            <div class="text-center text-gray-400 py-10">
                Belum ada absensi hari ini
            </div>

        @endif

    </div>

@endsection
