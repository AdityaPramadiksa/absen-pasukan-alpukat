@extends('layouts.admin')

@section('title', 'Absensi')

@section('content')

    <div class="space-y-6">

        {{-- TITLE --}}
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Data Absensi Staff</h1>
            <p class="text-sm text-gray-500">Rekap kehadiran seluruh staff</p>
        </div>

        {{-- FILTER --}}
        <div class="bg-white rounded-2xl shadow border p-5">

            <form class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">

                <div>
                    <label class="text-sm text-gray-500">Dari</label>
                    <input type="date" name="from" value="{{ request('from') }}"
                        class="w-full mt-1 rounded-xl border-gray-300">
                </div>

                <div>
                    <label class="text-sm text-gray-500">Sampai</label>
                    <input type="date" name="to" value="{{ request('to') }}"
                        class="w-full mt-1 rounded-xl border-gray-300">
                </div>

                <div>
                    <button class="w-full bg-gray-800 hover:bg-black text-white rounded-xl py-2">
                        Tampilkan
                    </button>
                </div>

            </form>

            @if (request('from'))
                <p class="text-xs text-gray-400 mt-3">
                    Menampilkan periode {{ request('from') }} – {{ request('to') }}
                </p>
            @endif

        </div>

        {{-- TABLE CARD --}}
        <div class="bg-white rounded-2xl shadow border overflow-hidden">

            {{-- DESKTOP --}}
            <div class="hidden md:block">

                <table class="w-full text-sm">

                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="px-6 py-3 text-left">Nama</th>
                            <th class="px-6 py-3 text-left">Tanggal</th>
                            <th class="px-6 py-3 text-left">Jam Masuk</th>
                            <th class="px-6 py-3 text-left">Shift</th>
                            <th class="px-6 py-3 text-center">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @forelse($data as $row)
                            <tr class="hover:bg-gray-50">

                                <td class="px-6 py-4 font-medium">
                                    {{ $row->name }}
                                </td>

                                <td class="px-6 py-4 text-gray-500">
                                    {{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}
                                </td>

                                <td class="px-6 py-4 text-gray-500">
                                    {{ \Carbon\Carbon::parse($row->checkin_time)->format('H:i') }}
                                </td>

                                <td class="px-6 py-4">

                                    <span
                                        class="px-3 py-1 text-xs rounded-full font-medium
        {{ $row->shift == 'O' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">

                                        {{ $row->shift == 'O' ? 'Opening' : 'Closing' }}

                                    </span>

                                </td>

                                <td class="px-6 py-4 text-center">

                                    <span
                                        class="px-3 py-1 text-xs rounded-full
                                {{ $row->status == 'ontime' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">

                                        {{ $row->status == 'ontime' ? 'On Time' : 'Telat' }}

                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="py-14">

                                    <div class="flex flex-col items-center text-gray-400 gap-2">

                                        <i data-lucide="calendar-x" class="w-10 h-10"></i>

                                        <p class="font-medium">
                                            Tidak ada absensi
                                        </p>

                                        <p class="text-xs">
                                            Tidak ditemukan data pada periode ini
                                        </p>

                                    </div>

                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- MOBILE --}}
            <div class="md:hidden divide-y">

                @forelse($data as $row)
                    <div class="p-4 space-y-2">

                        <div class="flex justify-between">

                            <p class="font-semibold">
                                {{ $row->name }}
                            </p>

                            <span
                                class="text-xs px-2 py-1 rounded-full
                        {{ $row->status == 'ontime' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">

                                {{ $row->status == 'ontime' ? 'On Time' : 'Telat' }}

                            </span>

                        </div>

                        <p class="text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}
                        </p>

                        <div class="flex justify-between text-sm">

                            <span>
                                Jam {{ \Carbon\Carbon::parse($row->checkin_time)->format('H:i') }}
                            </span>

                            <span
                                class="text-xs px-2 py-1 rounded-full font-medium
    {{ $row->shift == 'O' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">

                                {{ $row->shift == 'O' ? 'Opening' : 'Closing' }}

                            </span>

                        </div>

                    </div>

                @empty

                    <div class="py-12 flex flex-col items-center text-gray-400 gap-2">

                        <i data-lucide="calendar-x" class="w-10 h-10"></i>

                        <p class="font-medium">
                            Tidak ada absensi
                        </p>

                        <p class="text-xs">
                            Tidak ditemukan data pada periode ini
                        </p>

                    </div>
                @endforelse

            </div>

        </div>

    </div>

@endsection
