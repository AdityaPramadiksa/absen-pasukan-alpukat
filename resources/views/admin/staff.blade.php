@extends('layouts.admin')

@section('title', 'Data Staff')

@section('content')

    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-6">

        {{-- TITLE --}}
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Data Staff</h1>
            <p class="text-sm text-gray-500">Kelola akun & gaji staff</p>
        </div>

        {{-- FORM --}}
        <div class="bg-white rounded-2xl shadow border p-5">

            <form method="POST" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                @csrf

                <div>
                    <label class="text-sm text-gray-500">Nama</label>
                    <input name="name" required class="w-full mt-1 rounded-xl border-gray-300">
                </div>

                <div>
                    <label class="text-sm text-gray-500">Email</label>
                    <input name="email" required class="w-full mt-1 rounded-xl border-gray-300">
                </div>

                <div>
                    <label class="text-sm text-gray-500">Tipe</label>
                    <select name="employment_type" class="w-full mt-1 rounded-xl border-gray-300">
                        <option value="staff">Staff</option>
                        <option value="parttime">Part Time</option>
                        <option value="probation">Probation</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm text-gray-500">Weekday Rate</label>
                    <input type="number" name="weekday_rate" class="w-full mt-1 rounded-xl border-gray-300">
                </div>

                <div>
                    <label class="text-sm text-gray-500">Weekend Rate</label>
                    <input type="number" name="weekend_rate" class="w-full mt-1 rounded-xl border-gray-300">
                </div>

                <div class="flex items-end">
                    <button class="w-full bg-green-600 hover:bg-green-700 text-white rounded-xl py-2">
                        Tambah Staff
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
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-center">Tipe</th>
                        <th class="px-6 py-3 text-right">Weekday</th>
                        <th class="px-6 py-3 text-right">Weekend</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @foreach ($staff as $s)
                        @php
                            $type = strtolower(str_replace(' ', '', $s->employment_type));
                        @endphp

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-3 font-medium">{{ $s->name }}</td>

                            <td class="px-6 py-3 text-gray-500">{{ $s->email }}</td>

                            {{-- BADGE --}}
                            <td class="px-6 py-3 text-center">
                                @if ($type == 'staff')
                                    <span class="inline-block px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                        Staff
                                    </span>
                                @elseif($type == 'parttime')
                                    <span class="inline-block px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                        Part Time
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                                        Probation
                                    </span>
                                @endif
                            </td>


                            <td class="px-6 py-3 text-right">Rp {{ number_format($s->weekday_rate) }}</td>
                            <td class="px-6 py-3 text-right">Rp {{ number_format($s->weekend_rate) }}</td>

                            <td class="px-6 py-3 text-center">

                                <div class="flex justify-center gap-4">

                                    {{-- RESET --}}
                                    <form method="POST" action="/admin/staff/reset-password/{{ $s->id }}"
                                        onsubmit="return confirm('Reset password ke staff123?')">
                                        @csrf
                                        <button class="text-blue-500 hover:text-blue-700">
                                            <i data-lucide="refresh-ccw" class="w-4 h-4"></i>
                                        </button>
                                    </form>

                                    {{-- DELETE --}}
                                    <form method="POST" action="/admin/staff/{{ $s->id }}"
                                        onsubmit="return confirm('Hapus staff ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="text-red-500 hover:text-red-700">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

        {{-- MOBILE --}}
        <div class="md:hidden space-y-3">

            @foreach ($staff as $s)
                @php
                    $type = strtolower(str_replace(' ', '', $s->employment_type));
                @endphp


                <div class="bg-white rounded-xl shadow border p-4 space-y-2">

                    <p class="font-medium">{{ $s->name }}</p>
                    <p class="text-xs text-gray-400">{{ $s->email }}</p>

                    <div class="flex justify-between items-center pt-2">

                        <span
                            class="text-xs px-2 py-1 rounded-full
{{ $type == 'staff' ? 'bg-green-100 text-green-700' : ($type == 'parttime' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst($s->employment_type) }}
                        </span>

                        <span class="text-xs">WD {{ number_format($s->weekday_rate) }}</span>
                        <span class="text-xs">WE {{ number_format($s->weekend_rate) }}</span>

                    </div>

                    <div class="flex gap-4 pt-3">

                        <form method="POST" action="/admin/staff/reset-password/{{ $s->id }}">
                            @csrf
                            <button class="text-blue-500">
                                <i data-lucide="refresh-ccw" class="w-5 h-5"></i>
                            </button>
                        </form>

                        <form method="POST" action="/admin/staff/{{ $s->id }}">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500">
                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                            </button>
                        </form>

                    </div>

                </div>
            @endforeach

        </div>

    </div>

    <script>
        lucide.createIcons()
    </script>

@endsection
