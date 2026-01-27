<!DOCTYPE html>
<html>

<head>
    <title>Barcode Kost</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
            background: #f4f4f4;
        }

        .card {
            width: 350px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        #qrCode svg {
            width: 250px;
            height: 250px;
        }

        .btn {
            background: #007bff;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            margin-top: 15px;
        }
    </style>
</head>

<body>

    <div class="card">
        <h2>{{ $kost->nama_kost }}</h2>

        {{-- Tampilkan QR Code SVG --}}
        <div id="qrCode">{!! $qrSvg !!}</div>

        <p style="margin-top: 10px; font-size: 14px; color: gray;">
            Scan barcode untuk melihat detail kost
        </p>

        {{-- Tombol Download PNG --}}
        <button class="btn" onclick="downloadPng()">Download PNG</button>
    </div>

    <script>
        function downloadPng() {
            const svg = document.querySelector("#qrCode svg");
            const xml = new XMLSerializer().serializeToString(svg);

            const canvas = document.createElement("canvas");
            const ctx = canvas.getContext("2d");

            const img = new Image();
            img.onload = function() {
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0);

                const pngFile = canvas.toDataURL("image/png");

                const a = document.createElement("a");
                a.href = pngFile;
                a.download = "barcode-kost.png";
                a.click();
            };
            img.src = "data:image/svg+xml;base64," + btoa(xml);
        }
    </script>

</body>

</html>