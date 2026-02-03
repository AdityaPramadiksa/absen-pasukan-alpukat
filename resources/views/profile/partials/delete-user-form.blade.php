<section class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-2xl p-5 space-y-5">

    {{-- HEADER --}}
    <div>
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            Hapus Akun
        </h2>

        <p class="text-sm text-gray-500 dark:text-gray-400">
            Setelah akun dihapus, semua data akan hilang permanen.
            Pastikan sudah menyimpan data penting terlebih dahulu.
        </p>
    </div>

    {{-- DELETE BUTTON --}}
    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="rounded-xl text-sm px-4 py-2">
        Hapus Akun
    </x-danger-button>

    {{-- MODAL --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>

        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 space-y-4">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                Konfirmasi Hapus Akun
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Tindakan ini tidak bisa dibatalkan.
                Masukkan password untuk melanjutkan.
            </p>

            {{-- PASSWORD --}}
            <div>
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full rounded-xl"
                    placeholder="Masukkan password" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1" />
            </div>

            {{-- ACTION --}}
            <div class="flex justify-end gap-3 pt-2">

                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl">
                    Batal
                </x-secondary-button>

                <x-danger-button class="rounded-xl">
                    Hapus Akun
                </x-danger-button>

            </div>

        </form>

    </x-modal>

</section>
