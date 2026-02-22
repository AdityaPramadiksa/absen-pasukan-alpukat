@extends('layouts.staff')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <div class="p-4 space-y-4">

        {{-- ================= HEADER ================= --}}
        <div class="flex justify-between items-center">

            <div class="flex items-center gap-2">

                <span
                    class="inline-flex items-center justify-center
            w-9 h-9 rounded-full
            bg-pink-100 text-pink-700
            dark:bg-pink-900/30 dark:text-pink-300">

                    <i data-lucide="repeat" class="w-5 h-5"></i>

                </span>

                <h1 class="font-semibold text-lg text-gray-800 dark:text-white">
                    Buku Pergantian Topping
                </h1>

            </div>

            <button onclick="toggleModal(true)"
                class="bg-pink-600 hover:bg-pink-700
        text-white px-4 py-2 rounded-xl text-sm shadow-md">

                + Tambah
            </button>

        </div>



        {{-- ================= LIST DATA ================= --}}
        <div class="space-y-3">

            @forelse($logs as $log)
                <div
                    class="bg-white dark:bg-gray-900
        border border-gray-200 dark:border-gray-700
        rounded-2xl p-4 shadow-sm">

                    <div class="flex justify-between items-start">

                        <p class="text-xs text-gray-400">
                            {{ $log->tanggal->format('d M Y') }}
                        </p>

                        <span
                            class="inline-flex items-center gap-1 text-[10px] px-2 py-1 rounded-full
                bg-pink-100 text-pink-700
                dark:bg-pink-900/40 dark:text-pink-300">

                            <i data-lucide="repeat" class="w-3 h-3"></i>
                            Change
                        </span>

                    </div>


                    {{-- 🔥 VISUAL LAMA → BARU --}}
                    <div class="grid grid-cols-3 items-center mt-3 text-xs">

                        <div class="text-center">
                            <p class="text-gray-400">Dari</p>
                            <p class="font-semibold dark:text-white">
                                {{ $log->nama_toping_lama }}
                            </p>
                            <p class="text-gray-400">
                                {{ rtrim(rtrim($log->berat_lama, '0'), '.') }} g
                            </p>
                        </div>

                        <div class="text-center">
                            <i data-lucide="arrow-right" class="w-4 h-4 mx-auto text-gray-400"></i>
                        </div>

                        <div class="text-center">
                            <p class="text-gray-400">Menjadi</p>
                            <p class="font-semibold text-pink-600 dark:text-pink-300">
                                {{ $log->nama_toping_baru }}
                            </p>
                            <p class="text-gray-400">
                                {{ rtrim(rtrim($log->berat_baru, '0'), '.') }} g
                            </p>
                        </div>

                    </div>


                    {{-- FOTO --}}
                    @if ($log->foto)
                        <img src="{{ Storage::url($log->foto) }}" onclick="openImage('{{ Storage::url($log->foto) }}')"
                            class="mt-3 rounded-xl w-full h-32 object-cover cursor-zoom-in">
                    @endif


                    {{-- DELETE --}}
                    <form action="{{ route('topping-change.destroy', $log->id) }}" method="POST" class="mt-3"
                        onsubmit="return confirm('Hapus data ini?')">

                        @csrf
                        @method('DELETE')

                        <button class="text-xs text-red-500 flex items-center gap-1">
                            <i data-lucide="trash-2" class="w-3 h-3"></i>
                            Hapus data ini
                        </button>

                    </form>

                </div>

            @empty
                <div class="text-center text-gray-400 text-sm pt-10">
                    Belum ada pergantian topping
                </div>
            @endforelse

        </div>

    </div>



    {{-- ================= MODAL INPUT ================= --}}
    <div id="modal" class="fixed inset-0 bg-black/40 hidden items-end justify-center z-50 backdrop-blur-sm">

        <div class="bg-white dark:bg-gray-900 w-full max-w-md
rounded-t-3xl p-5 animate-slideUp shadow-2xl">

            <h2 class="font-semibold text-center mb-4 dark:text-white">
                Input Pergantian Topping
            </h2>

            <form action="{{ route('topping-change.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-3">

                @csrf

                <input type="text" name="nama_toping_lama" required placeholder="Toping Lama"
                    class="w-full border border-gray-300 dark:border-gray-700
bg-gray-50 dark:bg-gray-800 dark:text-white
rounded-xl p-3 text-sm">

                <input type="number" step="0.01" name="berat_lama" placeholder="Berat Lama (g)"
                    class="w-full border border-gray-300 dark:border-gray-700
bg-gray-50 dark:bg-gray-800 dark:text-white
rounded-xl p-3 text-sm">

                <input type="text" name="nama_toping_baru" required placeholder="Toping Baru"
                    class="w-full border border-gray-300 dark:border-gray-700
bg-gray-50 dark:bg-gray-800 dark:text-white
rounded-xl p-3 text-sm">

                <input type="number" step="0.01" name="berat_baru" placeholder="Berat Baru (g)"
                    class="w-full border border-gray-300 dark:border-gray-700
bg-gray-50 dark:bg-gray-800 dark:text-white
rounded-xl p-3 text-sm">

                <input type="file" name="foto" class="w-full text-xs text-gray-400">

                <textarea name="keterangan" placeholder="Keterangan (optional)"
                    class="w-full border border-gray-300 dark:border-gray-700
bg-gray-50 dark:bg-gray-800 dark:text-white
rounded-xl p-3 text-sm"></textarea>

                <button class="bg-pink-600 hover:bg-pink-700
text-white w-full p-3 rounded-xl font-medium">
                    Simpan
                </button>

            </form>

            <button onclick="toggleModal(false)" class="text-xs mt-4 text-center w-full text-gray-400">
                Tutup
            </button>

        </div>
    </div>



    {{-- IMAGE MODAL --}}
    <div id="imageModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-[60]" onclick="closeImage()">

        <img id="previewImage" class="max-h-[90vh] max-w-[90vw] rounded-xl shadow-2xl">

    </div>



    <script>
        function toggleModal(state) {
            const m = document.getElementById('modal')
            state ? m.classList.replace('hidden', 'flex') :
                m.classList.replace('flex', 'hidden')
        }

        function openImage(src) {
            const modal = document.getElementById('imageModal')
            const img = document.getElementById('previewImage')

            img.src = src
            modal.classList.remove('hidden')
            modal.classList.add('flex')
        }

        function closeImage() {
            const modal = document.getElementById('imageModal')
            modal.classList.add('hidden')
            modal.classList.remove('flex')
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
