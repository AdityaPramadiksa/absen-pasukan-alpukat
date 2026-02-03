@extends('layouts.staff')

@section('content')
    @if (session('success'))
        <div
            class="bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400
        p-3 rounded-xl mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-6">

        {{-- TITLE --}}
        <div>
            <h1 class="text-xl font-semibold">Lembur</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Input & riwayat lembur kamu
            </p>
        </div>

        {{-- FORM INPUT --}}
        <div class="bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-2xl p-4">

            <form method="POST" action="{{ route('staff.overtime') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="text-xs text-gray-500">Tanggal</label>

                    <input type="date" name="date" required
                        class="mt-1 w-full rounded-xl border-gray-300 dark:border-gray-700
                    dark:bg-gray-800 text-sm">
                </div>

                <div>
                    <label class="text-xs text-gray-500">Jumlah Jam</label>

                    <input type="number" name="hours" required placeholder="Contoh: 2"
                        class="mt-1 w-full rounded-xl border-gray-300 dark:border-gray-700
                    dark:bg-gray-800 text-sm">
                </div>

                <button
                    class="w-full bg-green-600 hover:bg-green-700 active:scale-[0.98]
                text-white rounded-xl py-2 text-sm transition">
                    Simpan Lembur
                </button>

            </form>

        </div>

        {{-- SUMMARY --}}
        <div
            class="bg-green-50 dark:bg-green-900/30 border dark:border-green-900
        rounded-2xl p-4 space-y-1 text-sm">

            <div class="flex justify-between">
                <span>Total Jam</span>
                <b>{{ $totalJam }} jam</b>
            </div>

            <div class="flex justify-between">
                <span>Tarif / jam</span>
                <b>Rp {{ number_format($rate) }}</b>
            </div>

            <div class="border-t border-green-200 dark:border-green-800 pt-2 flex justify-between font-semibold">

                <span>Total Lembur</span>

                <span class="text-green-700 dark:text-green-400">
                    Rp {{ number_format($totalRupiah) }}
                </span>

            </div>

        </div>

        {{-- RIWAYAT --}}
        <div>

            <h2 class="font-medium mb-3">
                Riwayat Lembur
            </h2>

            <div class="space-y-3">

                @forelse ($data as $r)
                    <div
                        class="bg-white dark:bg-gray-900 border dark:border-gray-700
                    rounded-xl p-4 flex justify-between items-center
                    active:scale-[0.98] transition">

                        <div>

                            <p class="text-sm font-medium">
                                {{ \Carbon\Carbon::parse($r->date)->format('d M Y') }}
                            </p>

                            <p class="text-xs text-gray-500">
                                {{ $r->hours }} jam
                            </p>

                        </div>

                    </div>

                @empty

                    <div class="text-center text-gray-400 dark:text-gray-500 py-10">

                        <i data-lucide="clock" class="w-10 h-10 mx-auto mb-3 opacity-40"></i>

                        <p class="text-sm">
                            Belum ada data lembur
                        </p>

                    </div>
                @endforelse

            </div>

        </div>

    </div>
@endsection
