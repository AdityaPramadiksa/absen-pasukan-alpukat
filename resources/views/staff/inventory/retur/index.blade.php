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
                bg-orange-100 text-orange-700
                dark:bg-orange-900/30 dark:text-orange-300">

                    <i data-lucide="corner-up-left" class="w-5 h-5"></i>
                </span>

                <h1 class="font-semibold text-lg text-gray-800 dark:text-white">
                    Buku Retur
                </h1>

            </div>

            <button onclick="toggleModal(true)"
                class="bg-orange-600 hover:bg-orange-700
            text-white px-4 py-2 rounded-xl text-sm
            shadow-md active:scale-95 transition">

                + Tambah
            </button>

        </div>


        {{-- ================= LIST DATA ================= --}}
        <div class="space-y-3">

            @forelse($logs as $r)
                <div
                    class="bg-white dark:bg-gray-900
                border border-gray-200 dark:border-gray-700
                rounded-2xl p-4 shadow-sm">

                    <div class="flex justify-between items-start">

                        <div>
                            <p class="font-semibold text-sm text-gray-800 dark:text-white">
                                {{ $r->nama_item }}
                            </p>

                            <p class="text-xs text-gray-400">
                                {{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y') }}
                            </p>
                        </div>

                        <span
                            class="inline-flex items-center gap-1 text-[10px] px-2 py-1 rounded-full
                        bg-orange-100 text-orange-700
                        dark:bg-orange-900/40 dark:text-orange-300">

                            <i data-lucide="corner-up-left" class="w-3 h-3"></i>
                            Retur
                        </span>

                    </div>

                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                        Supplier :
                        <span class="font-semibold">
                            {{ $r->supplier->nama_supplier ?? '-' }}
                        </span>
                    </div>

                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        Berat :
                        <span class="font-semibold">
                            {{ rtrim(rtrim($r->berat, '0'), '.') }}
                        </span> gram
                    </div>


                    {{-- IMAGE CLICKABLE --}}
                    @if ($r->foto)
                        <img src="{{ Storage::url($r->foto) }}" onclick="openImage('{{ Storage::url($r->foto) }}')"
                            class="mt-3 rounded-xl w-full h-32 object-cover cursor-zoom-in hover:scale-[1.02] transition">
                    @endif


                    {{-- DELETE --}}
                    <form action="{{ route('retur.destroy', $r->id) }}" method="POST" class="mt-3"
                        onsubmit="return confirm('Hapus data retur ini?')">

                        @csrf
                        @method('DELETE')

                        <button class="text-xs text-red-500 hover:text-red-600 flex items-center gap-1">
                            <i data-lucide="trash-2" class="w-3 h-3"></i>
                            Hapus data ini
                        </button>

                    </form>

                </div>

            @empty
                <div class="text-center text-sm text-gray-400 py-10">
                    Belum ada data retur
                </div>
            @endforelse

        </div>

    </div>



    {{-- ================= MODAL INPUT ================= --}}
    <div id="modal" class="fixed inset-0 bg-black/40 hidden items-end justify-center z-50 backdrop-blur-sm">

        <div class="bg-white dark:bg-gray-900 w-full max-w-md
        rounded-t-3xl p-5 animate-slideUp shadow-2xl">

            <h2 class="font-semibold mb-4 text-center text-gray-800 dark:text-white">
                Input Retur
            </h2>

            <form action="{{ route('retur.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">

                @csrf

                <input type="text" name="nama_item" required placeholder="Nama Barang"
                    class="w-full border border-gray-300 dark:border-gray-700
                bg-gray-50 dark:bg-gray-800 dark:text-white
                rounded-xl p-3 text-sm">

                <select name="supplier_id"
                    class="w-full border border-gray-300 dark:border-gray-700
                bg-gray-50 dark:bg-gray-800 dark:text-white
                rounded-xl p-3 text-sm">

                    <option value="">Tanpa Supplier</option>

                    @foreach ($suppliers as $s)
                        <option value="{{ $s->id }}">
                            {{ $s->nama_supplier }}
                        </option>
                    @endforeach
                </select>

                <input type="number" step="0.01" name="berat" required placeholder="Berat Retur (gram)"
                    class="w-full border border-gray-300 dark:border-gray-700
                bg-gray-50 dark:bg-gray-800 dark:text-white
                rounded-xl p-3 text-sm">

                <input type="file" name="foto" class="w-full text-xs text-gray-400">

                <textarea name="alasan" placeholder="Alasan retur (optional)"
                    class="w-full border border-gray-300 dark:border-gray-700
                bg-gray-50 dark:bg-gray-800 dark:text-white
                rounded-xl p-3 text-sm"></textarea>

                <button
                    class="bg-orange-600 hover:bg-orange-700
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



    {{-- ================= MODAL PREVIEW IMAGE ================= --}}
    <div id="imageModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-[60]" onclick="closeImage()">

        <img id="previewImage" class="max-h-[90vh] max-w-[90vw] rounded-xl shadow-2xl animate-zoom">

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
            animation: slideUp .25s ease;
        }

        @keyframes zoomIn {
            from {
                transform: scale(.8);
                opacity: 0
            }

            to {
                transform: scale(1);
                opacity: 1
            }
        }

        .animate-zoom {
            animation: zoomIn .2s ease;
        }
    </style>
@endsection
