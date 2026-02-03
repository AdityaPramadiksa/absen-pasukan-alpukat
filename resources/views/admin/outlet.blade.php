<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Avocado Lovers</title>

    @vite(['resources/css/app.css'])

    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

</head>

<body class="bg-green-900 min-h-screen flex items-center justify-center">

    <div class="flex flex-col items-center gap-6">

        <!-- QR CARD -->
        <div class="bg-white rounded-3xl shadow-xl p-8 max-w-sm w-full text-center">

            <h1 class="text-2xl font-bold mb-1">AVOCADO LOVERS</h1>
            <p class="text-gray-500 mb-6">Scan untuk Absen</p>

            <div id="qrcode" class="flex justify-center mb-6"></div>

            <div class="flex justify-center items-center gap-2 text-2xl font-bold">
                ⏱ <span id="clock"></span>
            </div>

            <p class="text-sm text-gray-400 mt-2">
                Refresh QR dalam <span id="counter">30</span> detik
            </p>

        </div>

        <!-- BACK BUTTON -->
        <a href="/login" class="text-white text-sm flex items-center gap-2 opacity-80 hover:opacity-100 transition">

            ← Kembali ke Login

        </a>

    </div>

    <script>
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
                        width: 220
                    }, (err, canvas) => {
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
