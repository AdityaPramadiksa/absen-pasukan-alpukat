@extends('layouts.staff')

@section('content')
    <div class="space-y-5">

        {{-- TITLE --}}
        <div>
            <h2 class="text-lg font-semibold">
                Scan Absensi QR
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Pastikan kamu berada maksimal <b>100 meter</b> dari outlet
            </p>
        </div>

        {{-- STATUS --}}
        <div id="status"
            class="text-sm bg-gray-100 dark:bg-gray-800 border dark:border-gray-700 rounded-xl px-4 py-3 text-gray-600 dark:text-gray-300">
            📍 Mendeteksi lokasi...
        </div>

        {{-- CAMERA --}}
        <div class="rounded-2xl overflow-hidden border dark:border-gray-700 shadow">

            <div id="reader" class="bg-black"></div>

        </div>

        {{-- BACK --}}
        <a href="/staff" class="block text-center text-sm text-gray-400 hover:text-green-600 transition">
            Kembali ke dashboard
        </a>

    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        const status = document.getElementById('status');

        navigator.geolocation.getCurrentPosition(position => {

            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            status.innerHTML = "✅ Lokasi terdeteksi. Arahkan kamera ke QR";

            const qr = new Html5Qrcode("reader");

            qr.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: 250
                },

                qrCodeMessage => {

                    status.innerHTML = "⏳ Mengirim absensi...";

                    fetch('/staff/absen', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                token: qrCodeMessage,
                                latitude: lat,
                                longitude: lng
                            })
                        })
                        .then(res => res.json())
                        .then(data => {

                            alert(data.message);

                            qr.stop();

                            if (data.success) {
                                window.location.href = '/staff';
                            }

                        });

                }
            );

        }, () => {

            status.innerHTML = "❌ Aktifkan GPS terlebih dahulu";

        });
    </script>
@endsection
