@extends('layouts.staff')

@section('content')
    <div class="space-y-5">

        {{-- TITLE --}}
        <div>
            <h2 class="text-lg font-semibold">
                Jadwal Saya
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Jadwal kerja minggu ini
            </p>
        </div>

        <div class="space-y-3">

            @forelse ($data as $d)
                <div
                    class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-2xl p-4 flex justify-between items-center transition">

                    <div>

                        <p class="text-sm font-medium">
                            {{ \Carbon\Carbon::parse($d->date)->translatedFormat('l') }}
                        </p>

                        <p class="text-xs text-gray-400">
                            {{ \Carbon\Carbon::parse($d->date)->format('d M Y') }}
                        </p>

                    </div>

                    <div>

                        @if ($d->shift == 'O')
                            <span
                                class="px-3 py-1 rounded-full text-xs bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300">
                                Opening
                            </span>
                        @else
                            <span
                                class="px-3 py-1 rounded-full text-xs bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300">
                                Closing
                            </span>
                        @endif

                    </div>

                </div>

            @empty

                <div class="text-center py-12">

                    <i data-lucide="calendar-x" class="w-10 h-10 mx-auto mb-3 text-gray-400"></i>

                    <p class="text-gray-400 text-sm">
                        Belum ada jadwal
                    </p>

                </div>
            @endforelse

        </div>

    </div>
@endsection
