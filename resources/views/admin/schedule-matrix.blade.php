@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        {{-- TITLE --}}
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Schedule Matrix</h1>
            <p class="text-sm text-gray-500">Tampilan jadwal staff per minggu (read only)</p>
        </div>

        {{-- WEEK PICKER --}}
        <div class="bg-white rounded-2xl shadow-sm border p-4">
            <form class="flex flex-col sm:flex-row items-end gap-3">
                <div>
                    <label class="text-sm text-gray-500">Pilih Senin</label>
                    <input type="date" name="week_start" value="{{ $weekStart }}"
                        class="mt-1 rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500">
                </div>
                <button class="bg-gray-800 hover:bg-black text-white rounded-xl px-4 py-2">
                    Tampilkan
                </button>
            </form>
        </div>

        {{-- DESKTOP MATRIX --}}
        <div class="hidden md:block bg-white rounded-2xl shadow-sm border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-max text-sm">
                    {{-- HEADER --}}
                    <thead class="bg-gray-50 text-gray-500">
                        <tr>
                            <th class="sticky left-0 bg-gray-50 z-10 px-4 py-3 text-left">
                                Nama
                            </th>
                            @foreach ($dates as $d)
                                <th class="px-4 py-3 text-center whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($d)->format('D') }}
                                    <div class="text-xs text-gray-400">
                                        {{ \Carbon\Carbon::parse($d)->format('d M') }}
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    {{-- BODY --}}
                    <tbody class="divide-y">
                        @foreach ($staff as $s)
                            <tr>
                                <td class="sticky left-0 bg-white px-4 py-3 font-medium text-gray-700 whitespace-nowrap">
                                    {{ $s->name }}
                                </td>
                                @foreach ($dates as $d)
                                    @php
                                        $val = $map[$s->id][$d] ?? 'OFF';
                                    @endphp
                                    <td class="px-4 py-3 text-center">
                                        @if ($val == 'OFF')
                                            <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-500">
                                                OFF
                                            </span>
                                        @elseif ($val == 'O')
                                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">
                                                O
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-600">
                                                C
                                            </span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MOBILE CARDS --}}
        <div class="md:hidden space-y-4">
            @foreach ($staff as $s)
                <div class="bg-white rounded-2xl shadow-sm border p-4">
                    <h3 class="font-medium text-gray-800 mb-3">{{ $s->name }}</h3>
                    <div class="grid grid-cols-7 gap-2">
                        @foreach ($dates as $d)
                            @php
                                $val = $map[$s->id][$d] ?? 'OFF';
                            @endphp
                            <div class="text-center">
                                <div class="text-xs text-gray-500 mb-1">
                                    {{ \Carbon\Carbon::parse($d)->format('D') }}
                                </div>
                                @if ($val == 'OFF')
                                    <span class="inline-block px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-500">
                                        OFF
                                    </span>
                                @elseif ($val == 'O')
                                    <span class="inline-block px-2 py-1 text-xs rounded-full bg-green-100 text-green-600">
                                        O
                                    </span>
                                @else
                                    <span class="inline-block px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-600">
                                        C
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
