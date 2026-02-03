@extends('layouts.admin')

@section('content')
    <div class="space-y-6">

        {{-- TITLE --}}
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Payroll</h1>
            <p class="text-sm text-gray-500">
                Rekap gaji staff (absensi + cuti + lembur)
            </p>
        </div>

        {{-- FILTER --}}
        <div class="bg-white rounded-2xl shadow border p-5">

            <form class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">

                <div>
                    <label class="text-sm text-gray-500">Dari</label>
                    <input type="date" name="from" value="{{ $from }}"
                        class="w-full mt-1 rounded-xl border-gray-300">
                </div>

                <div>
                    <label class="text-sm text-gray-500">Sampai</label>
                    <input type="date" name="to" value="{{ $to }}"
                        class="w-full mt-1 rounded-xl border-gray-300">
                </div>

                <div>
                    <button class="w-full bg-gray-800 hover:bg-black text-white rounded-xl py-2">
                        Tampilkan
                    </button>
                </div>

                <div>
                    <a href="{{ route('admin.payroll.export', ['from' => $from, 'to' => $to]) }}"
                        class="block text-center bg-green-600 text-white rounded-xl py-2">
                        Export Excel
                    </a>
                </div>

            </form>

        </div>

        {{-- DESKTOP --}}
        <div class="hidden md:block bg-white rounded-2xl shadow border overflow-hidden">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Nama</th>
                        <th class="px-5 py-3 text-center">Weekday</th>
                        <th class="px-5 py-3 text-center">Weekend</th>
                        <th class="px-5 py-3 text-center">Cuti</th>
                        <th class="px-5 py-3 text-center">Lembur</th>
                        <th class="px-5 py-3 text-center">Total</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @foreach ($recap as $r)
                        <tr class="hover:bg-gray-50">

                            <td class="px-5 py-3 font-medium">
                                {{ $r['name'] }}
                            </td>

                            <td class="px-5 py-3 text-center">
                                {{ $r['weekday'] }} × {{ number_format($r['weekday_rate']) }}
                            </td>

                            <td class="px-5 py-3 text-center">
                                {{ $r['weekend'] }} × {{ number_format($r['weekend_rate']) }}
                            </td>

                            <td class="px-5 py-3 text-center">
                                {{ $r['cuti'] }} hari
                            </td>

                            <td class="px-5 py-3 text-center">
                                {{ $r['overtime_hours'] }} jam
                            </td>

                            <td class="px-5 py-3 text-center font-semibold text-green-700">
                                Rp {{ number_format($r['total']) }}
                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

        {{-- MOBILE --}}
        <div class="md:hidden space-y-3">

            @foreach ($recap as $r)
                <div class="bg-white rounded-xl shadow border p-4 space-y-1">

                    <p class="font-medium">{{ $r['name'] }}</p>

                    <p class="text-xs text-gray-500">
                        Weekday: {{ $r['weekday'] }} × {{ number_format($r['weekday_rate']) }}
                    </p>

                    <p class="text-xs text-gray-500">
                        Weekend: {{ $r['weekend'] }} × {{ number_format($r['weekend_rate']) }}
                    </p>

                    <p class="text-xs text-gray-500">
                        Cuti: {{ $r['cuti'] }} hari
                    </p>

                    <p class="text-xs text-gray-500">
                        Lembur: {{ $r['overtime_hours'] }} jam
                    </p>

                    <p class="font-semibold text-green-700 mt-2">
                        Rp {{ number_format($r['total']) }}
                    </p>

                </div>
            @endforeach

        </div>

    </div>
@endsection
