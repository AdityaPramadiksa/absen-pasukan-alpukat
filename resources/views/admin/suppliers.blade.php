@extends('layouts.admin')

@section('title', 'Supplier')

@section('content')

    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-6">

        {{-- TITLE --}}
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Master Supplier</h1>
            <p class="text-sm text-gray-500">Kelola supplier buah & bahan</p>
        </div>

        {{-- FORM TAMBAH --}}
        <div class="bg-white rounded-2xl shadow border p-5">

            <form method="POST" action="/admin/suppliers" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @csrf

                <div>
                    <label class="text-sm text-gray-500">Nama Supplier</label>
                    <input name="nama_supplier" required class="w-full mt-1 rounded-xl border-gray-300">
                </div>

                <div>
                    <label class="text-sm text-gray-500">No HP</label>
                    <input name="no_hp" class="w-full mt-1 rounded-xl border-gray-300">
                </div>

                <div class="md:col-span-2">
                    <label class="text-sm text-gray-500">Alamat</label>
                    <input name="alamat" class="w-full mt-1 rounded-xl border-gray-300">
                </div>

                <div class="md:col-span-4 flex justify-end">
                    <button class="bg-green-600 hover:bg-green-700 text-white rounded-xl px-6 py-2">
                        Tambah Supplier
                    </button>
                </div>

            </form>

        </div>

        {{-- DESKTOP TABLE --}}
        <div class="hidden md:block bg-white rounded-xl shadow border overflow-hidden">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">No HP</th>
                        <th class="px-6 py-3 text-left">Alamat</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @foreach ($suppliers as $s)
                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-3 font-medium">{{ $s->nama_supplier }}</td>
                            <td class="px-6 py-3 text-gray-500">{{ $s->no_hp }}</td>
                            <td class="px-6 py-3 text-gray-500">{{ $s->alamat }}</td>

                            <td class="px-6 py-3 text-center">
                                <form method="POST" action="/admin/suppliers/{{ $s->id }}"
                                    onsubmit="return confirm('Hapus supplier ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="text-red-500 hover:text-red-700">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

        {{-- MOBILE --}}
        <div class="md:hidden space-y-3">

            @foreach ($suppliers as $s)
                <div class="bg-white rounded-xl shadow border p-4 space-y-2">

                    <p class="font-medium">{{ $s->nama_supplier }}</p>
                    <p class="text-xs text-gray-400">{{ $s->no_hp }}</p>
                    <p class="text-xs text-gray-500">{{ $s->alamat }}</p>

                    <form method="POST" action="/admin/suppliers/{{ $s->id }}">
                        @csrf
                        @method('DELETE')

                        <button class="text-red-500">
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </button>
                    </form>

                </div>
            @endforeach

        </div>

    </div>

    <script>
        lucide.createIcons()
    </script>

@endsection
