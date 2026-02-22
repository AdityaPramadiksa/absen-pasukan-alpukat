<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Outlet QR Display - Avocado Lovers</title>

    @vite(['resources/css/app.css'])

    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
</head>

<body
    class="min-h-screen font-sans
    bg-gradient-to-br from-green-900 via-emerald-800 to-green-700
    flex items-center justify-center
    p-6
    opacity-0 translate-y-4 transition duration-500"
    id="page">

    <div class="w-full max-w-md md:max-w-xl lg:max-w-2xl mx-auto">

        {{-- CONTAINER --}}
        <div
            class="bg-white/90 backdrop-blur-xl
            rounded-[32px] shadow-2xl
            border border-white/40
            p-8 md:p-10 text-center
            relative overflow-hidden">

            {{-- DECORATION GLOW --}}
            <div class="absolute -top-20 -right-20 w-60 h-60 bg-green-400/20 blur-3xl rounded-full">
            </div>

            {{-- LOGO --}}
            <div
                class="mx-auto mb-6 w-16 h-16 rounded-2xl
                bg-green-800 text-white flex items-center justify-center shadow-lg">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h6v6H3V3zm12 0h6v6h-6V3zM3 15h6v6H3v-6zm9 3h3v3h-3v-3zm0-12h3v3h-3V6zm6 6h3v3h-3v-3z" />
                </svg>

            </div>

            {{-- TITLE --}}
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                Avocado Lovers
            </h1>

            <p class="text-gray-500 text-sm mb-8">
                Scan QR untuk Absensi Staff
            </p>

            {{-- QR AREA --}}
            <div
                class="bg-white rounded-2xl
                shadow-inner border
                p-6 mb-6
                flex justify-center">

                <div id="qrcode"></div>

            </div>

            {{-- CLOCK --}}
            <div
                class="flex justify-center items-center gap-2
                text-xl md:text-2xl font-semibold text-gray-700">

                ⏱ <span id="clock"></span>

            </div>

            {{-- COUNTER --}}
            <p class="text-sm text-gray-400 mt-2">
                QR akan refresh dalam
                <span id="counter" class="font-semibold text-green-700">30</span>
                detik
            </p>

        </div>

        {{-- BACK BUTTON --}}
        <div class="text-center mt-6">

            <a href="/login"
                class="inline-flex items-center gap-2
                text-white/90 hover:text-white
                text-sm font-medium
                transition">

                ← Kembali ke Login

            </a>

        </div>

    </div>


    {{-- SCRIPT --}}
    <script>
        // ================= PAGE TRANSITION =================
        window.addEventListener('DOMContentLoaded', () => {
            const page = document.getElementById('page')
            page.classList.remove('opacity-0', 'translate-y-4')
        })

        let seconds = 30;

        function updateClock() {
            const now = new Date();
            document.getElementById('clock').innerText =
                now.toLocaleTimeString('id-ID');
        }

        setInterval(updateClock, 1000);
        updateClock();

        function loadQR() {

            fetch('/qr-public')
                .then(res => res.json())
                .then(data => {

                    document.getElementById('qrcode').innerHTML = "";

                    QRCode.toCanvas(data.token, {
                        width: 220,
                        margin: 1
                    }, (err, canvas) => {
                        canvas.classList.add('rounded-xl')
                        document.getElementById('qrcode').appendChild(canvas);
                    });

                });

            seconds = 30;
        }

        loadQR();

        setInterval(() => {

            seconds--;
            document.getElementById('counter').innerText = seconds;

            if (seconds <= 0) {
                loadQR();
            }

        }, 1000);
    </script>

</body>

</html>
