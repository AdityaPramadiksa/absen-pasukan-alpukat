@extends('layouts.admin')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-6">

        {{-- TITLE --}}
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Data Lembur</h1>
            <p class="text-sm text-gray-500">Rekap jam lembur staff</p>
        </div>

        {{-- RATE --}}
        <div class="bg-white rounded-2xl shadow border p-5">

            <form method="POST" action="/admin/overtime-rate" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                @csrf

                <div>
                    <label class="text-sm text-gray-500">Tarif per Jam</label>
                    <input type="number" name="rate" value="{{ $rate }}"
                        class="w-full mt-1 rounded-xl border-gray-300">
                </div>

                <div>
                    <button class="w-full bg-green-600 hover:bg-green-700 text-white rounded-xl py-2">
                        Simpan Tarif
                    </button>
                </div>

            </form>

        </div>

        {{-- SUMMARY --}}
        <div class="bg-white rounded-2xl shadow border p-5">

            <h2 class="font-medium mb-3">Rekap Lembur per Staff</h2>

            <div class="space-y-3">

                @foreach ($summary as $s)
                    <div class="flex justify-between items-center border rounded-xl p-4">

                        <div>
                            <p class="font-medium">{{ $s->name }}</p>
                            <p class="text-xs text-gray-400">{{ $s->total_hours }} jam</p>
                        </div>

                        <div class="text-right">
                            <p class="font-semibold text-green-700">
                                Rp {{ number_format($s->total_rupiah) }}
                            </p>
                        </div>

                    </div>
                @endforeach

            </div>

        </div>

        {{-- RIWAYAT HEADER --}}
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Riwayat Lembur</h2>
            <p class="text-sm text-gray-500">Detail lembur per tanggal</p>
        </div>

        {{-- DESKTOP TABLE --}}
        <div class="hidden md:block bg-white rounded-2xl shadow border overflow-hidden">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Nama</th>
                        <th class="px-5 py-3 text-center">Tanggal</th>
                        <th class="px-5 py-3 text-center">Jam</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @foreach ($data as $d)
                        <tr>
                            <td class="px-5 py-3">{{ $d->name }}</td>
                            <td class="px-5 py-3 text-center">
                                {{ \Carbon\Carbon::parse($d->date)->format('d M Y') }}
                            </td>
                            <td class="px-5 py-3 text-center font-medium">
                                {{ $d->hours }} jam
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

        {{-- MOBILE CARD --}}
        <div class="md:hidden space-y-3">

            @foreach ($data as $d)
                <div class="bg-white rounded-xl shadow border p-4">

                    <p class="font-medium">{{ $d->name }}</p>

                    <p class="text-xs text-gray-400">
                        {{ \Carbon\Carbon::parse($d->date)->format('d M Y') }}
                    </p>

                    <p class="text-sm mt-2">
                        {{ $d->hours }} jam
                    </p>

                </div>
            @endforeach

        </div>

    </div>
@endsection
