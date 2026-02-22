@extends('layouts.staff')

@section('content')
    <div class="p-4">

        {{-- TITLE --}}
        <h1 class="text-lg font-bold mb-4 dark:text-white">
            Inventory Control
        </h1>

        <div class="grid grid-cols-2 gap-4">

            {{-- ================= STOCK ================= --}}
            <a href="{{ route('stock.index') }}"
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
        rounded-2xl p-4 hover:shadow-md transition">

                <div class="flex flex-col items-center gap-2">

                    <span
                        class="inline-flex items-center justify-center
                w-12 h-12 rounded-full
                bg-green-100 text-green-700
                dark:bg-green-900/30 dark:text-green-300">

                        <i data-lucide="package" class="w-6 h-6"></i>
                    </span>

                    <p class="text-xs font-medium text-gray-700 dark:text-gray-200">
                        Stok
                    </p>

                </div>
            </a>


            {{-- ================= WASTE ================= --}}
            <a href="{{ route('waste.index') }}"
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
        rounded-2xl p-4 hover:shadow-md transition">

                <div class="flex flex-col items-center gap-2">

                    <span
                        class="inline-flex items-center justify-center
                w-12 h-12 rounded-full
                bg-red-100 text-red-700
                dark:bg-red-900/30 dark:text-red-300">

                        <i data-lucide="trash-2" class="w-6 h-6"></i>
                    </span>

                    <p class="text-xs font-medium text-gray-700 dark:text-gray-200">
                        Waste
                    </p>

                </div>
            </a>


            {{-- ================= BANTAI ================= --}}
            <a href="{{ route('bantai.index') }}"
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
        rounded-2xl p-4 hover:shadow-md transition">

                <div class="flex flex-col items-center gap-2">

                    <span
                        class="inline-flex items-center justify-center
                w-12 h-12 rounded-full
                bg-purple-100 text-purple-700
                dark:bg-purple-900/30 dark:text-purple-300">

                        <i data-lucide="scissors" class="w-6 h-6"></i>
                    </span>

                    <p class="text-xs font-medium text-gray-700 dark:text-gray-200">
                        Bantai
                    </p>

                </div>
            </a>


            {{-- ================= BARANG MASUK ================= --}}
            <a href="{{ route('barangmasuk.index') }}"
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
        rounded-2xl p-4 hover:shadow-md transition">

                <div class="flex flex-col items-center gap-2">

                    <span
                        class="inline-flex items-center justify-center
                w-12 h-12 rounded-full
                bg-blue-100 text-blue-700
                dark:bg-blue-900/30 dark:text-blue-300">

                        <i data-lucide="download" class="w-6 h-6"></i>
                    </span>

                    <p class="text-xs font-medium text-gray-700 dark:text-gray-200">
                        Barang Masuk
                    </p>

                </div>
            </a>


            {{-- ================= RETUR ================= --}}
            <a href="{{ route('retur.index') }}"
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
        rounded-2xl p-4 hover:shadow-md transition">

                <div class="flex flex-col items-center gap-2">

                    <span
                        class="inline-flex items-center justify-center
                w-12 h-12 rounded-full
                bg-orange-100 text-orange-700
                dark:bg-orange-900/30 dark:text-orange-300">

                        <i data-lucide="corner-up-left" class="w-6 h-6"></i>
                    </span>

                    <p class="text-xs font-medium text-gray-700 dark:text-gray-200">
                        Retur
                    </p>

                </div>
            </a>


            {{-- ================= CHIPS (BARU 🔥) ================= --}}
            <a href="{{ route('chips.index') }}"
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
        rounded-2xl p-4 hover:shadow-md transition">

                <div class="flex flex-col items-center gap-2">

                    <span
                        class="inline-flex items-center justify-center
                w-12 h-12 rounded-full
                bg-yellow-100 text-yellow-700
                dark:bg-yellow-900/30 dark:text-yellow-300">

                        <i data-lucide="cookie" class="w-6 h-6"></i>
                    </span>

                    <p class="text-xs font-medium text-gray-700 dark:text-gray-200">
                        Chips
                    </p>

                </div>
            </a>

            {{-- ================= PENJUALAN CHIPS ================= --}}
            <a href="{{ route('chips.sales.index') }}"
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
rounded-2xl p-4 hover:shadow-md transition">

                <div class="flex flex-col items-center gap-2">

                    <span
                        class="inline-flex items-center justify-center
        w-12 h-12 rounded-full
        bg-yellow-200 text-yellow-800
        dark:bg-yellow-900/30 dark:text-yellow-300">

                        <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                    </span>

                    <p class="text-xs font-medium text-gray-700 dark:text-gray-200">
                        Penjualan Chips
                    </p>

                </div>
            </a>

            {{-- ================= PERGANTIAN TOPPING ================= --}}
            <a href="{{ route('topping-change.index') }}"
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
rounded-2xl p-4 hover:shadow-md transition">

                <div class="flex flex-col items-center gap-2">

                    <span
                        class="inline-flex items-center justify-center
        w-12 h-12 rounded-full
        bg-pink-100 text-pink-700
        dark:bg-pink-900/30 dark:text-pink-300">

                        <i data-lucide="repeat" class="w-6 h-6"></i>
                    </span>

                    <p class="text-xs font-medium text-gray-700 dark:text-gray-200">
                        Pergantian Topping
                    </p>

                </div>
            </a>

        </div>

    </div>

    <script>
        lucide.createIcons()
    </script>
@endsection
