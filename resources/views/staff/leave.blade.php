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
            <h1 class="text-xl font-semibold">Cuti</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Ajukan & lihat status cuti
            </p>
        </div>

        {{-- FORM AJUAN --}}
        <div class="bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-2xl p-4 space-y-4">

            <form method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="text-xs text-gray-500">Tanggal</label>

                    <input type="date" name="date" required
                        class="mt-1 w-full rounded-xl border-gray-300 dark:border-gray-700
                    dark:bg-gray-800 text-sm">
                </div>

                <div>
                    <label class="text-xs text-gray-500">Alasan</label>

                    <input name="reason" required placeholder="Contoh: acara keluarga"
                        class="mt-1 w-full rounded-xl border-gray-300 dark:border-gray-700
                    dark:bg-gray-800 text-sm">
                </div>

                <button
                    class="w-full bg-green-600 hover:bg-green-700 active:scale-[0.98]
                text-white rounded-xl py-2 text-sm transition">
                    Ajukan Cuti
                </button>

            </form>

        </div>

        {{-- RIWAYAT --}}
        <div>

            <h2 class="font-medium mb-3">
                Riwayat Cuti
            </h2>

            <div class="space-y-3">

                @forelse ($data as $d)
                    <div
                        class="bg-white dark:bg-gray-900 border dark:border-gray-700
                    rounded-xl p-4 space-y-2 active:scale-[0.98] transition">

                        <div class="flex justify-between items-start">

                            <div>
                                <p class="font-medium text-sm">
                                    {{ \Carbon\Carbon::parse($d->date)->format('d M Y') }}
                                </p>

                                <p class="text-xs text-gray-500">
                                    {{ $d->reason }}
                                </p>
                            </div>

                            {{-- STATUS BADGE --}}
                            <span
                                class="text-[11px] px-2 py-1 rounded-full

                            {{ $d->status == 'approved'
                                ? 'bg-green-100 dark:bg-green-900/40 text-green-600 dark:text-green-400'
                                : ($d->status == 'rejected'
                                    ? 'bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-400'
                                    : 'bg-yellow-100 dark:bg-yellow-900/40 text-yellow-600 dark:text-yellow-400') }}">

                                {{ ucfirst($d->status) }}

                            </span>

                        </div>

                        {{-- REJECT REASON --}}
                        @if ($d->status == 'rejected')
                            <p class="text-xs text-red-500 dark:text-red-400">
                                Alasan: {{ $d->reject_reason }}
                            </p>
                        @endif

                    </div>

                @empty

                    <div class="text-center text-gray-400 dark:text-gray-500 py-10">

                        <i data-lucide="calendar-x" class="w-10 h-10 mx-auto mb-3 opacity-40"></i>

                        <p class="text-sm">
                            Belum ada pengajuan cuti
                        </p>

                    </div>
                @endforelse

            </div>

        </div>

    </div>
@endsection
