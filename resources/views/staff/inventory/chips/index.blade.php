@extends('layouts.staff')

@section('content')
    <div class="p-4 space-y-4">

        {{-- HEADER --}}
        <div class="flex justify-between items-center">

            <div class="flex items-center gap-2">

                <span
                    class="inline-flex items-center justify-center
            w-9 h-9 rounded-full
            bg-yellow-100 text-yellow-700
            dark:bg-yellow-900/30 dark:text-yellow-300">

                    <i data-lucide="cookie" class="w-5 h-5"></i>

                </span>

                <h1 class="font-semibold text-lg text-gray-800 dark:text-white">
                    Buku Chips
                </h1>

            </div>

            <button onclick="toggleModal(true)"
                class="bg-yellow-600 hover:bg-yellow-700
        text-white px-4 py-2 rounded-xl text-sm shadow-md">

                + Tambah
            </button>

        </div>


        {{-- LIST --}}
        <div class="space-y-3">

            @forelse($chips as $chip)
                @php
                    $badge =
                        $chip->qty_stock <= 0
                            ? 'bg-red-100 text-red-700'
                            : ($chip->qty_stock <= 5
                                ? 'bg-yellow-100 text-yellow-700'
                                : 'bg-green-100 text-green-700');
                @endphp

                <div
                    class="bg-white dark:bg-gray-900
        border border-gray-200 dark:border-gray-700
        rounded-2xl p-4 shadow-sm">

                    <div class="flex justify-between items-center">

                        <div>
                            <p class="font-semibold text-sm text-gray-800 dark:text-white">
                                {{ $chip->nama_chips }}
                            </p>

                            <span class="text-[10px] px-2 py-1 rounded-full {{ $badge }}">
                                Stok : {{ $chip->qty_stock }}
                            </span>
                        </div>

                        <div class="flex items-center gap-2">

                            {{-- EDIT STOK --}}
                            <button onclick="openAdjust({{ $chip->id }},{{ $chip->qty_stock }})"
                                class="px-3 py-1 rounded-full text-[11px]
    bg-blue-100 text-blue-600
    dark:bg-blue-900/30 dark:text-blue-300
    hover:opacity-80 transition">

                                Edit
                            </button>

                            {{-- JUAL --}}
                            <a href="{{ route('chips.sales.index') }}"
                                class="px-3 py-1 rounded-full text-[11px]
    bg-yellow-100 text-yellow-700
    dark:bg-yellow-900/30 dark:text-yellow-300
    hover:opacity-80 transition">

                                Jual
                            </a>

                            {{-- DELETE --}}
                            <form action="{{ route('chips.destroy', $chip->id) }}" method="POST"
                                onsubmit="return confirm('Hapus chips ini?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="px-3 py-1 rounded-full text-[11px]
        bg-red-100 text-red-600
        dark:bg-red-900/30 dark:text-red-300
        hover:opacity-80 transition">

                                    Hapus
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @empty
                <div class="text-center text-gray-400 text-sm pt-10">
                    Belum ada chips
                </div>
            @endforelse

        </div>

    </div>



    {{-- MODAL TAMBAH --}}
    <div id="modal" class="fixed inset-0 bg-black/40 hidden items-end justify-center z-50 backdrop-blur-sm">

        <div class="bg-white dark:bg-gray-900 w-full max-w-md
    rounded-t-3xl p-5 animate-slideUp shadow-2xl">

            <h2 class="font-semibold text-center mb-4 dark:text-white">
                Tambah Chips
            </h2>

            <form action="{{ route('chips.store') }}" method="POST" class="space-y-3">

                @csrf

                <input type="text" name="nama_chips" required placeholder="Nama Chips"
                    class="w-full border border-gray-300 dark:border-gray-700
            bg-gray-50 dark:bg-gray-800 dark:text-white
            rounded-xl p-3 text-sm">

                <input type="number" name="qty_stock" required placeholder="Stok Awal"
                    class="w-full border border-gray-300 dark:border-gray-700
            bg-gray-50 dark:bg-gray-800 dark:text-white
            rounded-xl p-3 text-sm">

                <button class="bg-yellow-600 hover:bg-yellow-700
            text-white w-full p-3 rounded-xl font-medium">
                    Simpan
                </button>

            </form>

            <button onclick="toggleModal(false)" class="text-xs mt-4 text-center w-full text-gray-400">
                Tutup
            </button>

        </div>
    </div>



    {{-- MODAL ADJUST STOCK --}}
    <div id="adjustModal" class="fixed inset-0 bg-black/40 hidden items-end justify-center z-50 backdrop-blur-sm">

        <div class="bg-white dark:bg-gray-900 w-full max-w-md
    rounded-t-3xl p-5 animate-slideUp shadow-2xl">

            <h2 class="font-semibold text-center mb-4 dark:text-white">
                Sesuaikan Stok
            </h2>

            <form id="adjustForm" method="POST" class="space-y-3">

                @csrf

                <input type="number" name="qty_stock" id="adjustQty" required
                    class="w-full border border-gray-300 dark:border-gray-700
            bg-gray-50 dark:bg-gray-800 dark:text-white
            rounded-xl p-3 text-sm">

                <button class="bg-blue-600 hover:bg-blue-700
            text-white w-full p-3 rounded-xl font-medium">
                    Update Stok
                </button>

            </form>

            <button onclick="toggleAdjust(false)" class="text-xs mt-4 text-center w-full text-gray-400">
                Tutup
            </button>

        </div>
    </div>



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

        function toggleAdjust(state) {
            const m = document.getElementById('adjustModal')

            if (state) {
                m.classList.remove('hidden')
                m.classList.add('flex')
            } else {
                m.classList.add('hidden')
                m.classList.remove('flex')
            }
        }

        function openAdjust(id, qty) {

            // isi value qty
            document.getElementById('adjustQty').value = qty

            // 🔥 gunakan route laravel (ANTI ERROR 404)
            let url = "{{ route('chips.adjust', ':id') }}"
            url = url.replace(':id', id)

            document.getElementById('adjustForm').action = url

            toggleAdjust(true)
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
            animation: slideUp .25s ease
        }
    </style>
@endsection
