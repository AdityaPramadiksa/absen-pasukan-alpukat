@extends('layouts.admin')

@section('content')
    <div class="space-y-6">

        {{-- TITLE --}}
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Pengajuan Cuti</h1>
            <p class="text-sm text-gray-500">Approve atau tolak cuti staff</p>
        </div>

        {{-- ================= DESKTOP TABLE ================= --}}
        <div class="hidden md:block bg-white rounded-2xl shadow-sm border overflow-hidden">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">Tanggal</th>
                        <th class="px-6 py-3 text-left">Alasan</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @foreach ($data as $d)
                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-3 font-medium">{{ $d->name }}</td>

                            <td class="px-6 py-3 text-gray-500">
                                {{ \Carbon\Carbon::parse($d->date)->format('d M Y') }}
                            </td>

                            <td class="px-6 py-3">{{ $d->reason }}</td>

                            {{-- STATUS --}}
                            <td class="px-6 py-3 text-center">
                                <span
                                    class="text-xs px-3 py-1 rounded-full
                            {{ $d->status == 'approved'
                                ? 'bg-green-100 text-green-700'
                                : ($d->status == 'rejected'
                                    ? 'bg-red-100 text-red-700'
                                    : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ ucfirst($d->status) }}
                                </span>
                            </td>

                            {{-- ACTION --}}
                            <td class="px-6 py-3 text-center">

                                @if ($d->status == 'pending')
                                    <div class="flex justify-center gap-3">

                                        {{-- APPROVE --}}
                                        <form method="POST" action="/admin/leave/{{ $d->id }}/approve">
                                            @csrf
                                            <button
                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-lg text-xs">
                                                Approve
                                            </button>
                                        </form>

                                        {{-- REJECT --}}
                                        <form method="POST" action="/admin/leave/{{ $d->id }}/reject"
                                            class="flex gap-2">
                                            @csrf
                                            <input name="reason" placeholder="Alasan"
                                                class="border rounded-lg px-2 text-xs">

                                            <button
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs">
                                                Reject
                                            </button>
                                        </form>

                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif

                            </td>

                        </tr>

                        @if ($d->status == 'rejected')
                            <tr>
                                <td colspan="5" class="px-6 pb-3 text-xs text-red-500">
                                    Alasan penolakan: {{ $d->reject_reason }}
                                </td>
                            </tr>
                        @endif
                    @endforeach

                </tbody>

            </table>

        </div>

        {{-- ================= MOBILE CARD ================= --}}
        <div class="md:hidden space-y-3">

            @foreach ($data as $d)
                <div class="bg-white rounded-2xl shadow-sm border p-4 space-y-2">

                    <div class="flex justify-between items-center">

                        <p class="font-medium">{{ $d->name }}</p>

                        <span
                            class="text-xs px-3 py-1 rounded-full
                    {{ $d->status == 'approved'
                        ? 'bg-green-100 text-green-700'
                        : ($d->status == 'rejected'
                            ? 'bg-red-100 text-red-700'
                            : 'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst($d->status) }}
                        </span>

                    </div>

                    <p class="text-xs text-gray-400">
                        {{ \Carbon\Carbon::parse($d->date)->format('d M Y') }}
                    </p>

                    <p class="text-sm">{{ $d->reason }}</p>

                    @if ($d->status == 'pending')
                        <div class="flex gap-2 pt-2">

                            <form method="POST" action="/admin/leave/{{ $d->id }}/approve" class="flex-1">
                                @csrf
                                <button class="w-full bg-green-600 text-white rounded-xl py-2 text-xs">
                                    Approve
                                </button>
                            </form>

                            <form method="POST" action="/admin/leave/{{ $d->id }}/reject" class="flex-1 space-y-1">
                                @csrf
                                <input name="reason" placeholder="Alasan"
                                    class="w-full border rounded-xl px-2 py-1 text-xs">

                                <button class="w-full bg-red-500 text-white rounded-xl py-2 text-xs">
                                    Reject
                                </button>
                            </form>

                        </div>
                    @endif

                    @if ($d->status == 'rejected')
                        <p class="text-xs text-red-500">
                            Alasan: {{ $d->reject_reason }}
                        </p>
                    @endif

                </div>
            @endforeach

        </div>

    </div>
@endsection
