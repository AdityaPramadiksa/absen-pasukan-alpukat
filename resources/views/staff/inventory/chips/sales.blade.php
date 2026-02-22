@extends('layouts.staff')

@section('content')
    <div class="p-4 space-y-4">

        {{-- HEADER --}}
        <div class="flex items-center gap-2">

            <span
                class="inline-flex items-center justify-center
        w-9 h-9 rounded-full
        bg-yellow-100 text-yellow-700
        dark:bg-yellow-900/30 dark:text-yellow-300">

                <i data-lucide="shopping-bag" class="w-5 h-5"></i>

            </span>

            <h1 class="font-semibold text-lg text-gray-800 dark:text-white">
                Penjualan Chips
            </h1>

        </div>



        {{-- ================= LIST CHIPS (KASIR CARD) ================= --}}
        <div class="grid grid-cols-2 gap-3">

            @forelse($chips as $chip)
                @php
                    $badge =
                        $chip->qty_stock <= 0
                            ? 'bg-red-100 text-red-700'
                            : ($chip->qty_stock <= 5
                                ? 'bg-yellow-100 text-yellow-700'
                                : 'bg-green-100 text-green-700');
                @endphp

                <button onclick="openModal({{ $chip->id }},'{{ $chip->nama_chips }}',{{ $chip->qty_stock }})"
                    {{ $chip->qty_stock <= 0 ? 'disabled' : '' }}
                    class="bg-white dark:bg-gray-900
        border border-gray-200 dark:border-gray-700
        rounded-2xl p-4 shadow-sm
        hover:shadow-md transition
        {{ $chip->qty_stock <= 0 ? 'opacity-40 cursor-not-allowed' : '' }}">

                    <div class="flex flex-col items-center gap-2">

                        <p class="text-sm font-semibold text-gray-800 dark:text-white text-center">
                            {{ $chip->nama_chips }}
                        </p>

                        <span class="text-[10px] px-2 py-1 rounded-full {{ $badge }}">
                            Stok : {{ $chip->qty_stock }}
                        </span>

                    </div>

                </button>

            @empty
                <div class="col-span-2 text-center text-gray-400 text-sm pt-10">
                    Belum ada chips
                </div>
            @endforelse

        </div>


        {{-- ================= HISTORY SALE ================= --}}
        <div class="space-y-3">

            @foreach ($sales as $sale)
                <div
                    class="bg-white dark:bg-gray-900
border border-gray-200 dark:border-gray-700
rounded-2xl p-4 shadow-sm">

                    <div class="flex justify-between items-start">

                        <div>
                            <p class="font-semibold text-sm dark:text-white">
                                {{ $sale->chip->nama_chips }}
                            </p>

                            <p class="text-xs text-gray-400">
                                {{ $sale->tanggal->format('d M Y') }}
                            </p>
                        </div>

                        <span
                            class="text-[10px] px-2 py-1 rounded-full
        bg-yellow-100 text-yellow-700
        dark:bg-yellow-900/40 dark:text-yellow-300">

                            {{ strtoupper($sale->metode_bayar) }}

                        </span>

                    </div>

                    {{-- DETAIL --}}
                    <div class="flex justify-between items-center mt-3">

                        <p class="text-xs text-gray-500">
                            Qty :
                            <span class="font-semibold">
                                {{ $sale->qty }}
                            </span>
                        </p>

                        {{-- DELETE ACTION PREMIUM --}}
                        <form action="{{ route('chips.sales.destroy', $sale->id) }}" method="POST"
                            onsubmit="return confirm('Hapus data penjualan ini?')">

                            @csrf
                            @method('DELETE')

                            <button
                                class="flex items-center gap-1 text-xs
            text-red-500 hover:text-red-600
            transition">

                                <i data-lucide="trash-2" class="w-3 h-3"></i>
                                Hapus

                            </button>

                        </form>

                    </div>

                </div>
            @endforeach

        </div>


        {{-- ================= MODAL JUAL ================= --}}
        <div id="modal" class="fixed inset-0 bg-black/40 hidden items-end justify-center z-50 backdrop-blur-sm">

            <div class="bg-white dark:bg-gray-900 w-full max-w-md
    rounded-t-3xl p-5 animate-slideUp shadow-2xl">

                <h2 id="modalTitle" class="font-semibold text-center mb-4 dark:text-white">
                    Jual Chips
                </h2>

                <form action="{{ route('chips.sales.store') }}" method="POST" class="space-y-3">

                    @csrf

                    <input type="hidden" name="chip_id" id="chip_id">

                    <input type="number" name="qty" id="qtyInput" required min="1" placeholder="Qty Terjual"
                        class="w-full border border-gray-300 dark:border-gray-700
            bg-gray-50 dark:bg-gray-800 dark:text-white
            rounded-xl p-3 text-sm">

                    <select name="metode_bayar"
                        class="w-full border border-gray-300 dark:border-gray-700
            bg-gray-50 dark:bg-gray-800 dark:text-white
            rounded-xl p-3 text-sm">

                        <option value="cash">Cash</option>
                        <option value="debit">Debit</option>
                        <option value="kredit">Kredit</option>
                        <option value="qris">QRIS</option>

                    </select>

                    <button
                        class="bg-yellow-600 hover:bg-yellow-700
            text-white w-full p-3 rounded-xl font-medium">
                        Simpan
                    </button>

                </form>

                <button onclick="toggleModal(false)" class="text-xs mt-4 text-center w-full text-gray-400">
                    Tutup
                </button>

            </div>
        </div>



        <script>
            let maxStock = 0

            function openModal(id, nama, stok) {
                document.getElementById('chip_id').value = id
                document.getElementById('modalTitle').innerText = 'Jual ' + nama
                document.getElementById('qtyInput').value = ''

                maxStock = stok

                toggleModal(true)
            }

            function toggleModal(state) {
                const m = document.getElementById('modal')

                state ? m.classList.replace('hidden', 'flex') :
                    m.classList.replace('flex', 'hidden')
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
