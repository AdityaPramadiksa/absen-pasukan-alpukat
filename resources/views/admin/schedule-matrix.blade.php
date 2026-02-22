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

                {{-- EXPORT BUTTON --}}
                <button type="button" onclick="exportSchedule()"
                    class="bg-green-600 hover:bg-green-700 text-white rounded-xl px-4 py-2">
                    Export Gambar
                </button>
            </form>
        </div>


        {{-- ================= EXPORT AREA ================= --}}
        <div id="scheduleExport" class="export-wrapper">

            {{-- DESKTOP MATRIX --}}
            <div class="hidden md:block bg-white rounded-2xl shadow-sm border overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-max text-sm w-full">

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
                                    <td
                                        class="sticky left-0 bg-white px-4 py-3 font-medium text-gray-700 whitespace-nowrap">
                                        {{ $s->name }}
                                    </td>

                                    @foreach ($dates as $d)
                                        @php
                                            $val = $map[$s->id][$d] ?? 'OFF';
                                        @endphp

                                        <td class="px-4 py-3 text-center">

                                            {{-- BADGE FIX CENTER EXPORT SAFE --}}
                                            @if ($val == 'OFF')
                                                <span
                                                    class="mx-auto flex items-center justify-center w-12 h-6 text-xs rounded-full bg-gray-100 text-gray-500">
                                                    OFF
                                                </span>
                                            @elseif ($val == 'O')
                                                <span
                                                    class="mx-auto flex items-center justify-center w-8 h-6 text-xs rounded-full bg-green-100 text-green-600">
                                                    O
                                                </span>
                                            @elseif ($val == 'M')
                                                <span
                                                    class="mx-auto flex items-center justify-center w-8 h-6 text-xs rounded-full bg-yellow-100 text-yellow-600">
                                                    M
                                                </span>
                                            @else
                                                <span
                                                    class="mx-auto flex items-center justify-center w-8 h-6 text-xs rounded-full bg-blue-100 text-blue-600">
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

                        <h3 class="font-medium text-gray-800 mb-3">
                            {{ $s->name }}
                        </h3>

                        <div class="grid grid-cols-7 gap-2">

                            @foreach ($dates as $d)
                                @php
                                    $val = $map[$s->id][$d] ?? 'OFF';
                                @endphp

                                <div class="text-center">

                                    <div class="text-xs text-gray-500 mb-1">
                                        {{ \Carbon\Carbon::parse($d)->format('D') }}
                                    </div>

                                    {{-- MOBILE BADGE FIX --}}
                                    @if ($val == 'OFF')
                                        <span
                                            class="mx-auto flex items-center justify-center w-10 h-6 text-xs rounded-full bg-gray-100 text-gray-500">
                                            OFF
                                        </span>
                                    @elseif ($val == 'O')
                                        <span
                                            class="mx-auto flex items-center justify-center w-8 h-6 text-xs rounded-full bg-green-100 text-green-600">
                                            O
                                        </span>
                                    @elseif ($val == 'M')
                                        <span
                                            class="mx-auto flex items-center justify-center w-8 h-6 text-xs rounded-full bg-yellow-100 text-yellow-600">
                                            M
                                        </span>
                                    @else
                                        <span
                                            class="mx-auto flex items-center justify-center w-8 h-6 text-xs rounded-full bg-blue-100 text-blue-600">
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
        {{-- ================= END EXPORT AREA ================= --}}


    </div>

    {{-- ================= EXPORT SCRIPT HD VERSION ================= --}}

    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    <script>
        function exportSchedule() {

            const element = document.getElementById('scheduleExport');

            html2canvas(element, {
                scale: 3, // HD EXPORT 🔥
                backgroundColor: "#ffffff",
                useCORS: true
            }).then(canvas => {

                const link = document.createElement('a');
                link.download = 'jadwal-staff.png';
                link.href = canvas.toDataURL('image/png');
                link.click();

            });
        }
    </script>

    {{-- FIX HTML2CANVAS ALIGNMENT --}}

    <style>
        .export-wrapper * {
            letter-spacing: 0 !important;
            line-height: 1 !important;
        }
    </style>
@endsection
