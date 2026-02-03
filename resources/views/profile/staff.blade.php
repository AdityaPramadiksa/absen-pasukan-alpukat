@extends('layouts.staff')

@section('content')
    @php
        $user = Auth::user();
    @endphp

    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">
        Profil Saya
    </h2>

    <div class="space-y-4">

        {{-- INFO PROFILE --}}
        <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-2xl p-4">

            <h3 class="font-medium mb-3 text-sm text-gray-900 dark:text-gray-100">
                Informasi Akun
            </h3>

            @include('profile.partials.update-profile-information-form')

        </div>

        {{-- PASSWORD --}}
        <div class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-2xl p-4">

            <h3 class="font-medium mb-3 text-sm text-gray-900 dark:text-gray-100">
                Ganti Password
            </h3>

            @include('profile.partials.update-password-form')

        </div>

        {{-- DELETE ACCOUNT --}}
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-4">

            <h3 class="font-medium mb-3 text-sm text-red-600 dark:text-red-400">
                Hapus Akun
            </h3>

            @include('profile.partials.delete-user-form')

        </div>

    </div>
@endsection
