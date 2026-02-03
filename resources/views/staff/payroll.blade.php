@extends('layouts.staff')

@section('content')
    <div class="space-y-6">

        {{-- TITLE --}}
        <div>
            <h1 class="text-xl font-semibold">Payroll</h1>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Periode
                {{ \Carbon\Carbon::parse($from)->format('d M') }}
                –
                {{ \Carbon\Carbon::parse($to)->format('d M Y') }}
            </p>
        </div>

        {{-- FILTER --}}
        <div class="bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-2xl p-4">

            <form class="grid grid-cols-2 gap-3 items-end">

                <div>
                    <label class="text-xs text-gray-500">Dari</label>

                    <input type="date" name="from" value="{{ $from }}"
                        class="mt-1 w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm">
                </div>

                <div>
                    <label class="text-xs text-gray-500">Sampai</label>

                    <input type="date" name="to" value="{{ $to }}"
                        class="mt-1 w-full rounded-xl border-gray-300 dark:border-gray-700 dark:bg-gray-800 text-sm">
                </div>

                <div class="col-span-2">
                    <button
                        class="w-full bg-gray-800 dark:bg-green-600 hover:bg-black dark:hover:bg-green-700
                    text-white rounded-xl py-2 text-sm transition">
                        Tampilkan
                    </button>
                </div>

            </form>

        </div>

        {{-- HARI KERJA --}}
        <div class="bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-2xl p-4 space-y-3">

            <p class="text-sm font-medium">Hari Kerja</p>

            <div class="flex justify-between text-sm">
                <span>Weekday</span>
                <span>{{ $weekday }} × Rp{{ number_format($user->weekday_rate) }}</span>
            </div>

            <div class="flex justify-between text-sm">
                <span>Weekend</span>
                <span>{{ $weekend }} × Rp{{ number_format($user->weekend_rate) }}</span>
            </div>

            <div class="flex justify-between text-sm text-green-700 dark:text-green-400">
                <span>Cuti (dibayar)</span>
                <span>{{ $cutiCount }} hari</span>
            </div>

            @php
                $gajiPokok = ($weekday + $cutiCount) * $user->weekday_rate + $weekend * $user->weekend_rate;
            @endphp

            <div class="border-t dark:border-gray-700 pt-2 flex justify-between font-semibold">

                <span>Gaji Pokok</span>

                <span>
                    Rp{{ number_format($gajiPokok) }}
                </span>

            </div>

        </div>

        {{-- LEMBUR --}}
        <div class="bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-2xl p-4 space-y-3">

            <p class="text-sm font-medium">Lembur</p>

            <div class="flex justify-between text-sm">
                <span>Total Jam</span>
                <span>{{ $overtimeHours }} jam</span>
            </div>

            <div class="flex justify-between text-sm">
                <span>Tarif / Jam</span>
                <span>Rp{{ number_format($overtimeRate) }}</span>
            </div>

            @php
                $totalLembur = $overtimeHours * $overtimeRate;
            @endphp

            <div class="border-t dark:border-gray-700 pt-2 flex justify-between font-semibold">

                <span>Total Lembur</span>

                <span>
                    Rp{{ number_format($totalLembur) }}
                </span>

            </div>

        </div>

        {{-- GRAND TOTAL --}}
        <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-900
        rounded-2xl p-4">

            <div class="flex justify-between items-center">

                <span class="font-medium">
                    TOTAL GAJI
                </span>

                <span class="text-lg font-bold text-green-700 dark:text-green-400">
                    Rp{{ number_format($gajiPokok + $totalLembur) }}
                </span>

            </div>

        </div>

    </div>
@endsection
