@extends('layouts.admin')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded-xl mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-6">

        {{-- TITLE --}}
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Weekly Schedule</h1>
            <p class="text-sm text-gray-500">Atur jadwal kerja staff per minggu</p>
        </div>

        {{-- WEEK PICKER --}}
        <div class="bg-white rounded-2xl shadow-sm border p-4">
            <form method="GET" action="/admin/schedule" class="flex flex-col sm:flex-row gap-3 items-end">
                <div>
                    <label class="text-sm text-gray-500">Pilih Senin</label>
                    <input type="date" name="week_start" value="{{ $weekStart }}"
                        class="mt-1 rounded-xl border-gray-300">
                </div>

                <button class="bg-gray-800 text-white rounded-xl px-4 py-2">
                    Tampilkan
                </button>
            </form>
        </div>

        {{-- ================= DESKTOP FORM ================= --}}
        <form method="POST" action="/admin/schedule-grid" class="hidden md:block">
            @csrf
            <input type="hidden" name="week_start" value="{{ $weekStart }}">

            <button class="bg-green-600 text-white rounded-xl px-6 py-2 shadow mb-4">
                Simpan Jadwal
            </button>

            <div class="bg-white rounded-2xl shadow-sm border overflow-x-auto">

                <table class="min-w-max text-sm">

                    <thead class="bg-gray-50">
                        <tr>
                            <th class="sticky left-0 bg-gray-50 px-4 py-3">Nama</th>

                            @for ($i = 0; $i < 7; $i++)
                                @php $date=date('Y-m-d',strtotime($weekStart." +$i day")); @endphp
                                <th class="px-4 py-3 text-center whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($date)->format('D') }}
                                    <div class="text-xs text-gray-400">
                                        {{ \Carbon\Carbon::parse($date)->format('d M') }}
                                    </div>
                                </th>
                            @endfor
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @foreach ($staff as $s)
                            <tr>

                                <td class="sticky left-0 bg-white px-4 py-3 font-medium">
                                    {{ $s->name }}
                                </td>

                                @for ($i = 0; $i < 7; $i++)
                                    @php $date=date('Y-m-d',strtotime($weekStart." +$i day")); @endphp

                                    <td class="px-3 py-2 text-center">
                                        <select name="schedule[{{ $s->id }}][{{ $date }}]"
                                            class="rounded-xl border-gray-300 text-sm">
                                            <option value="off">OFF</option>
                                            @foreach ($shifts as $sh)
                                                <option value="{{ $sh->id }}">{{ $sh->code }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                @endfor

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>
        </form>

        {{-- ================= MOBILE FORM ================= --}}
        <form method="POST" action="/admin/schedule-grid" class="md:hidden">
            @csrf
            <input type="hidden" name="week_start" value="{{ $weekStart }}">

            <button class="bg-green-600 text-white rounded-xl px-6 py-2 shadow mb-4">
                Simpan Jadwal
            </button>

            <div class="space-y-4">

                @foreach ($staff as $s)
                    <div class="bg-white rounded-2xl shadow-sm border p-4 space-y-3">

                        <h3 class="font-semibold">{{ $s->name }}</h3>

                        @for ($i = 0; $i < 7; $i++)
                            @php $date=date('Y-m-d',strtotime($weekStart." +$i day")); @endphp

                            <div class="flex justify-between items-center text-sm">

                                <span class="text-gray-500">
                                    {{ \Carbon\Carbon::parse($date)->format('D d M') }}
                                </span>

                                <select name="schedule[{{ $s->id }}][{{ $date }}]"
                                    class="rounded-xl border-gray-300 text-sm">
                                    <option value="off">OFF</option>
                                    @foreach ($shifts as $sh)
                                        <option value="{{ $sh->id }}">{{ $sh->code }}</option>
                                    @endforeach
                                </select>

                            </div>
                        @endfor

                    </div>
                @endforeach

            </div>
        </form>

    </div>
@endsection
