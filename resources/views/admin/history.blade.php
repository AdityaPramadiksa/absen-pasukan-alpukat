@extends('layouts.admin')

@section('title', 'History Log')

@section('content')

    <div class="space-y-6">

        {{-- TITLE --}}
        <div>
            <h1 class="text-xl font-semibold text-gray-800">History Pencatatan</h1>
            <p class="text-sm text-gray-500">Monitoring semua buku inventory</p>
        </div>

        {{-- FILTER --}}
        <div class="bg-white rounded-2xl shadow border p-5">

            <form method="GET" class="grid md:grid-cols-4 gap-4">

                <div>
                    <label class="text-sm text-gray-500">Tipe</label>
                    <select name="type" class="w-full mt-1 rounded-xl border-gray-300">

                        <option value="">Semua</option>

                        <option value="masuk" {{ request('type') == 'masuk' ? 'selected' : '' }}>Barang Masuk</option>
                        <option value="waste" {{ request('type') == 'waste' ? 'selected' : '' }}>Waste</option>
                        <option value="bantai" {{ request('type') == 'bantai' ? 'selected' : '' }}>Bantai</option>
                        <option value="retur" {{ request('type') == 'retur' ? 'selected' : '' }}>Retur</option>
                        <option value="stock" {{ request('type') == 'stock' ? 'selected' : '' }}>Stock</option>
                        <option value="chips" {{ request('type') == 'chips' ? 'selected' : '' }}>Chips</option>

                    </select>
                </div>

                <div>
                    <label class="text-sm text-gray-500">Dari</label>
                    <input type="date" name="from" value="{{ request('from') }}"
                        class="w-full mt-1 rounded-xl border-gray-300">
                </div>

                <div>
                    <label class="text-sm text-gray-500">Sampai</label>
                    <input type="date" name="to" value="{{ request('to') }}"
                        class="w-full mt-1 rounded-xl border-gray-300">
                </div>

                <div class="flex items-end">
                    <button class="w-full bg-green-600 hover:bg-green-700 text-white rounded-xl py-2">
                        Filter
                    </button>
                </div>

            </form>

        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-xl shadow border overflow-hidden">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-6 py-3 text-left">Tanggal</th>
                        <th class="px-6 py-3 text-left">User</th>
                        <th class="px-6 py-3 text-left">Tipe</th>
                        <th class="px-6 py-3 text-left">Keterangan</th>
                        <th class="px-6 py-3 text-left">Foto</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($logs as $log)
                        @php
                            $badge = match ($log->tipe) {
                                'masuk' => 'bg-blue-100 text-blue-700',
                                'waste' => 'bg-red-100 text-red-700',
                                'bantai' => 'bg-purple-100 text-purple-700',
                                'retur' => 'bg-orange-100 text-orange-700',
                                'stock' => 'bg-green-100 text-green-700',
                                'chips' => 'bg-yellow-100 text-yellow-700',
                                default => 'bg-gray-100 text-gray-700',
                            };

                            $icon = match ($log->tipe) {
                                'masuk' => 'download',
                                'waste' => 'trash-2',
                                'bantai' => 'scissors',
                                'retur' => 'corner-up-left',
                                'stock' => 'package',
                                'chips' => 'cookie',
                                default => 'circle',
                            };
                        @endphp

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-3">
                                {{ \Carbon\Carbon::parse($log->tanggal)->format('d M Y') }}
                            </td>

                            <td class="px-6 py-3">
                                {{ $log->name ?? '-' }}
                            </td>

                            <td class="px-6 py-3">
                                <span
                                    class="inline-flex items-center gap-2 px-3 py-1 text-xs rounded-full {{ $badge }}">
                                    <i data-lucide="{{ $icon }}" class="w-3 h-3"></i>
                                    {{ ucfirst($log->tipe) }}
                                </span>
                            </td>

                            <td class="px-6 py-3 text-gray-500">
                                {{ $log->deskripsi ?? '-' }}
                            </td>

                            {{-- FOTO PREVIEW --}}
                            <td class="px-6 py-3">
                                @if ($log->foto)
                                    <img src="{{ Storage::url($log->foto) }}"
                                        onclick="openImage('{{ Storage::url($log->foto) }}')"
                                        class="w-12 h-12 object-cover rounded-lg cursor-zoom-in hover:scale-105 transition">
                                @else
                                    <span class="text-gray-300 text-xs">-</span>
                                @endif
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-400">
                                Belum ada data
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- IMAGE PREVIEW MODAL --}}
    <div id="imageModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-[60]" onclick="closeImage()">

        <img id="previewImage" class="max-h-[90vh] max-w-[90vw] rounded-xl shadow-2xl">

    </div>


    <script>
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

@endsection
