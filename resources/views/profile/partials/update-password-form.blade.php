<section class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-2xl p-5 space-y-5">

    {{-- HEADER --}}
    <div>
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            Update Password
        </h2>

        <p class="text-sm text-gray-500 dark:text-gray-400">
            Gunakan password panjang & unik agar akun tetap aman
        </p>
    </div>

    <form method="post" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        @method('put')

        {{-- CURRENT PASSWORD --}}
        <div>
            <x-input-label for="update_password_current_password" value="Password Lama" />
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="mt-1 block w-full rounded-xl" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
        </div>

        {{-- NEW PASSWORD --}}
        <div>
            <x-input-label for="update_password_password" value="Password Baru" />
            <x-text-input id="update_password_password" name="password" type="password"
                class="mt-1 block w-full rounded-xl" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
        </div>

        {{-- CONFIRM PASSWORD --}}
        <div>
            <x-input-label for="update_password_password_confirmation" value="Konfirmasi Password" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full rounded-xl" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
        </div>

        {{-- ACTION --}}
        <div class="flex items-center gap-3 pt-2">

            <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl text-sm transition">
                Simpan Password
            </button>

            @if (session('status') === 'password-updated')
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Password diperbarui ✓
                </p>
            @endif

        </div>

    </form>

</section>
