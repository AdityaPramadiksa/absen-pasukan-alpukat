@extends('layouts.admin')

@section('content')
    <div class="max-w-xl mx-auto space-y-6">

        {{-- HEADER --}}
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Edit Staff</h1>
            <p class="text-sm text-gray-500">Update data akun dan gaji staff</p>
        </div>

        {{-- CARD --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

            <form method="POST" action="/admin/staff/{{ $staff->id }}/update">
                @csrf

                <div class="space-y-5">

                    {{-- NAMA --}}
                    <div>
                        <label class="text-sm text-gray-500">Nama</label>
                        <input name="name" value="{{ $staff->name }}" required
                            class="w-full mt-1 rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500 transition">
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label class="text-sm text-gray-500">Email</label>
                        <input name="email" value="{{ $staff->email }}" required
                            class="w-full mt-1 rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500 transition">
                    </div>

                    {{-- TYPE --}}
                    <div>
                        <label class="text-sm text-gray-500">Employment Type</label>
                        <select name="employment_type"
                            class="w-full mt-1 rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500 transition">

                            <option value="staff" {{ $staff->employment_type == 'staff' ? 'selected' : '' }}>
                                Staff
                            </option>

                            <option value="parttime" {{ $staff->employment_type == 'parttime' ? 'selected' : '' }}>
                                Part Time
                            </option>

                            <option value="probation" {{ $staff->employment_type == 'probation' ? 'selected' : '' }}>
                                Probation
                            </option>

                        </select>
                    </div>

                    {{-- RATE --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>
                            <label class="text-sm text-gray-500">Weekday Rate</label>
                            <input type="number" name="weekday_rate" value="{{ $staff->weekday_rate }}"
                                class="w-full mt-1 rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500 transition">
                        </div>

                        <div>
                            <label class="text-sm text-gray-500">Weekend Rate</label>
                            <input type="number" name="weekend_rate" value="{{ $staff->weekend_rate }}"
                                class="w-full mt-1 rounded-xl border-gray-200 focus:border-green-500 focus:ring-green-500 transition">
                        </div>

                    </div>

                    {{-- ACTION --}}
                    <div class="flex justify-between pt-4">

                        <a href="/admin/staff" class="text-gray-500 hover:text-gray-800 transition">
                            ← Kembali
                        </a>

                        <button
                            class="bg-green-600 hover:bg-green-700 active:scale-95 transition text-white rounded-xl px-6 py-2 font-medium shadow">
                            Update Staff
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>
@endsection
