@extends('layouts.staff')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <div class="p-4 space-y-4">

        {{-- ================= HEADER ================= --}}
        <div class="flex justify-between items-center">

            <div class="flex items-center gap-2">

                {{-- ICON CONSISTENT WITH HISTORY --}}
                <span
                    class="inline-flex items-center justify-center
                w-9 h-9 rounded-full
                bg-green-100 text-green-700
                dark:bg-green-900/30 dark:text-green-300">

                    <i data-lucide="package" class="w-5 h-5"></i>
                </span>

                <h1 class="font-semibold text-lg text-gray-800 dark:text-white">
                    Buku Stok
                </h1>

            </div>

            <button onclick="toggleModal(true)"
                class="bg-green-600 hover:bg-green-700
            text-white px-4 py-2 rounded-xl text-sm
            shadow-md active:scale-95 transition">

                + Tambah
            </button>
        </div>


        {{-- ================= LIST DATA ================= --}}
        <div class="space-y-3">

            @forelse ($logs as $l)
                <div
                    class="bg-white dark:bg-gray-900
                border border-gray-200 dark:border-gray-700
                rounded-2xl p-4 shadow-sm">

                    <div class="flex justify-between items-start">

                        <div>
                            <p class="font-semibold text-sm text-gray-800 dark:text-white">
                                {{ $l->nama_item }}
                            </p>

                            <p class="text-xs text-gray-400">
                                {{ \Carbon\Carbon::parse($l->tanggal)->format('d M Y') }}
                            </p>
                        </div>

                        {{-- BADGE SHIFT (STYLE HISTORY SYSTEM) --}}
                        <span
                            class="inline-flex items-center gap-1 text-[10px] px-2 py-1 rounded-full
                        {{ $l->shift == 'pagi'
                            ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300'
                            : 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300' }}">

                            <i data-lucide="{{ $l->shift == 'pagi' ? 'sun' : 'moon' }}" class="w-3 h-3"></i>

                            {{ ucfirst($l->shift) }}
                        </span>

                    </div>


                    {{-- VALUE --}}
                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">

                        @if ($l->shift == 'pagi')
                            Before :
                            <span class="font-semibold">
                                {{ rtrim(rtrim($l->stok_before, '0'), '.') }} gram
                            </span>
                        @else
                            After :
                            <span class="font-semibold">
                                {{ rtrim(rtrim($l->stok_after, '0'), '.') }} gram </span>
                        @endif

                    </div>


                    {{-- IMAGE --}}
                    @if ($l->foto)
                        <img src="{{ Storage::url($l->foto) }}" class="mt-3 rounded-xl w-full h-32 object-cover">
                    @endif


                    {{-- DELETE LINK --}}
                    <form action="{{ route('stock.destroy', $l->id) }}" method="POST" class="mt-3"
                        onsubmit="return confirm('Hapus data stok ini?')">

                        @csrf
                        @method('DELETE')

                        <button class="text-xs text-red-500 hover:text-red-600 flex items-center gap-1">

                            <i data-lucide="trash-2" class="w-3 h-3"></i>

                            Hapus data ini
                        </button>

                    </form>

                </div>

            @empty

                <div class="text-center text-gray-400 text-sm pt-10">
                    Belum ada data stok
                </div>
            @endforelse

        </div>

    </div>



    {{-- ================= MODAL ================= --}}
    <div id="modal" class="fixed inset-0 bg-black/40 hidden items-end justify-center z-50 backdrop-blur-sm">

        <div class="bg-white dark:bg-gray-900 w-full max-w-md
        rounded-t-3xl p-5 animate-slideUp shadow-2xl">

            <h2 class="font-semibold text-center mb-4 text-gray-800 dark:text-white">
                Input Stok
            </h2>

            <form action="{{ route('stock.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">

                @csrf

                {{-- NAMA ITEM --}}
                <input type="text" name="nama_item" required placeholder="Nama Item (contoh: Alpukat)"
                    class="w-full border border-gray-300 dark:border-gray-700
                bg-gray-50 dark:bg-gray-800 dark:text-white
                rounded-xl p-3 text-sm">


                {{-- SHIFT --}}
                <select id="shiftSelect" name="shift" onchange="handleShift()"
                    class="w-full border border-gray-300 dark:border-gray-700
                bg-gray-50 dark:bg-gray-800 dark:text-white
                rounded-xl p-3 text-sm">

                    <option value="pagi">Pagi (Input Before)</option>
                    <option value="malam">Malam (Input After)</option>
                </select>


                {{-- BEFORE --}}
                <div id="beforeField">
                    <input type="number" step="0.01" name="stok_before" placeholder="Stok Before"
                        class="w-full border border-gray-300 dark:border-gray-700
                    bg-gray-50 dark:bg-gray-800 dark:text-white
                    rounded-xl p-3 text-sm">
                </div>


                {{-- AFTER --}}
                <div id="afterField" class="hidden">
                    <input type="number" step="0.01" name="stok_after" placeholder="Stok After"
                        class="w-full border border-gray-300 dark:border-gray-700
                    bg-gray-50 dark:bg-gray-800 dark:text-white
                    rounded-xl p-3 text-sm">
                </div>


                {{-- FOTO --}}
                <input type="file" name="foto" class="w-full text-xs text-gray-400">


                <button
                    class="bg-green-600 hover:bg-green-700
                text-white w-full p-3 rounded-xl
                font-medium active:scale-95 transition">

                    Simpan
                </button>

            </form>

            <button onclick="toggleModal(false)" class="text-xs mt-4 text-center w-full text-gray-400">
                Tutup
            </button>

        </div>
    </div>



    {{-- ================= SCRIPT ================= --}}
    <script>
        function toggleModal(state) {
            const m = document.getElementById('modal')

            if (state) {
                m.classList.remove('hidden')
                m.classList.add('flex')
            } else {
                m.classList.add('hidden')
                m.classList.remove('flex')
            }
        }

        function handleShift() {
            const shift = document.getElementById('shiftSelect').value
            const before = document.getElementById('beforeField')
            const after = document.getElementById('afterField')

            if (shift === 'pagi') {
                before.classList.remove('hidden')
                after.classList.add('hidden')
            } else {
                before.classList.add('hidden')
                after.classList.remove('hidden')
            }
        }

        lucide.createIcons()
    </script>



    <style>
        @keyframes slideUp {
            from {
                transform: translateY(100%);
                opacity: 0
            }

            to {
                transform: translateY(0);
                opacity: 1
            }
        }

        .animate-slideUp {
            animation: slideUp .25s ease;
        }
    </style>
@endsection
