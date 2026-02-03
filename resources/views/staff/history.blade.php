@extends('layouts.staff')

@section('content')
    <h2 class="text-lg font-semibold mb-4">
        Riwayat Absensi
    </h2>

    <div class="space-y-3">

        @forelse ($data as $row)
            <div
                class="bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-2xl p-4
            flex justify-between items-center active:scale-[0.98] transition">

                <div>

                    <p class="text-sm font-medium">
                        {{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}
                    </p>

                    <p class="text-xs text-gray-400">
                        Shift {{ $row->shift }}
                    </p>

                </div>

                <div class="text-right">

                    <p class="font-semibold text-sm">
                        {{ \Carbon\Carbon::parse($row->checkin_time)->format('H:i') }}
                    </p>

                    @if ($row->status == 'ontime')
                        <span
                            class="inline-block mt-1 text-[11px] px-2 py-1 rounded-full
                        bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-400">

                            On Time

                        </span>
                    @else
                        <span
                            class="inline-block mt-1 text-[11px] px-2 py-1 rounded-full
                        bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-400">

                            Telat

                        </span>
                    @endif

                </div>

            </div>

        @empty

            <div class="text-center text-gray-400 dark:text-gray-500 py-12">

                <i data-lucide="calendar-x" class="w-10 h-10 mx-auto mb-3 opacity-40"></i>

                <p class="text-sm">
                    Belum ada riwayat absensi
                </p>

            </div>
        @endforelse

    </div>
@endsection
