<section class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-2xl p-5 space-y-5">

    {{-- HEADER --}}
    <div>
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            Profile Information
        </h2>

        <p class="text-sm text-gray-500 dark:text-gray-400">
            Update nama & email akun kamu
        </p>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf
        @method('patch')

        {{-- NAME --}}
        <div>
            <x-input-label for="name" value="Nama" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-xl"
                :value="old('name', $user->name)" required autofocus />
            <x-input-error class="mt-1" :messages="$errors->get('name')" />
        </div>

        {{-- EMAIL --}}
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-xl"
                :value="old('email', $user->email)" required />
            <x-input-error class="mt-1" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-2 text-sm">

                    <p class="text-gray-500 dark:text-gray-400">
                        Email belum diverifikasi.

                        <button form="send-verification" class="underline text-green-600 dark:text-green-400 ml-1">
                            Kirim ulang verifikasi
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-green-600 dark:text-green-400 text-xs">
                            Link verifikasi sudah dikirim ulang.
                        </p>
                    @endif

                </div>
            @endif
        </div>

        {{-- ACTION --}}
        <div class="flex items-center gap-3 pt-2">

            <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl text-sm transition">
                Simpan
            </button>

            @if (session('status') === 'profile-updated')
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Tersimpan ✓
                </p>
            @endif

        </div>

    </form>

</section>
