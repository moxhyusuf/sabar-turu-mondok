<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Informasi Kost - {{ $kost->nama_kost }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --secondary: #fbbf24;
            --text-dark: #1f2937;
            --text-gray: #6b7280;
            --bg-page: #f9fafb;
            --bg-card: #ffffff;
        }

        @page {
            size: F4; /* Standard F4 size is roughly 210mm x 330mm */
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-page);
            color: var(--text-dark);
            line-height: 1.5;
            padding: 2rem;
            display: flex;
            justify-content: center;
        }

        .report-container {
            width: 100%;
            max-width: 210mm; /* A4 width as fallback check */
            min-height: 297mm;
            background-color: var(--bg-card);
            position: relative;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
            padding: 40px;
        }

        /* Border Ornamen Gradient Biru-Kuning */
        .report-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .report-container::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, var(--secondary), var(--primary));
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .header p {
            color: var(--text-gray);
            font-size: 14px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 15px;
            padding-left: 12px;
            border-left: 4px solid var(--primary);
            display: flex;
            align-items: center;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            background-color: #f8fafc;
            padding: 24px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-gray);
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .value {
            font-size: 15px;
            font-weight: 500;
            color: var(--text-dark);
        }

        .facilities-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            list-style: none;
        }

        .facility-item {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: var(--text-dark);
            padding: 8px 12px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
        }

        .facility-item::before {
            content: "✓";
            margin-right: 8px;
            color: #10b981;
            font-weight: bold;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .gallery-item {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #f3f4f6;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: var(--text-gray);
            font-style: italic;
        }

        @media print {
            body {
                background-color: white;
                padding: 0;
            }
            .report-container {
                box-shadow: none;
                width: 100%;
                max-width: none;
                border-radius: 0;
                padding: 40px;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="report-container">
        <div class="header">
            <h1>Informasi Kost</h1>
            <p>{{ $kost->nama_kost }} • Dicetak pada {{ now()->format('d M Y') }}</p>
        </div>

        <div class="section">
            <h2 class="section-title">Detail Umum</h2>
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Nama Kost</span>
                    <span class="value">{{ $kost->nama_kost }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Pemilik</span>
                    <span class="value">{{ $kost->nama_pemilik }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Alamat</span>
                    <span class="value">{{ $kost->alamat }}, {{ $kost->kelurahan }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Contact Person</span>
                    <span class="value">{{ $kost->contact_person }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Jenis Kost</span>
                    <span class="value">{{ ucfirst($kost->jenis_kost) }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Harga</span>
                    <span class="value">Rp {{ number_format($kost->harga, 0, ',', '.') }} / Bulan</span>
                </div>
                <div class="info-item">
                    <span class="label">Jumlah Kamar</span>
                    <span class="value">{{ $kost->jumlah_kamar }} Kamar</span>
                </div>
                <div class="info-item">
                    <span class="label">Sisa Kamar</span>
                    <span class="value">{{ $kost->kamar_tersedia }} Kamar</span>
                </div>
                <div class="info-item" style="grid-column: span 2;">
                    <span class="label">Lokasi Pemondokan</span>
                    <span class="value">{{ $kost->lokasi_pemondokan ?: 'Tidak tersedia' }}</span>
                </div>
            </div>
        </div>

        @if($kost->fasilitas)
        <div class="section">
            <h2 class="section-title">Fasilitas</h2>
            <ul class="facilities-list">
                @foreach([
                    'lahan_parkir' => 'Lahan Parkir',
                    'pagar' => 'Pagar',
                    'cctv' => 'CCTV',
                    'ac_kipas' => 'AC / Kipas',
                    'meteran_listrik' => 'Meteran Listrik',
                    'wifi' => 'WiFi',
                    'peraturan_penghuni' => 'Peraturan Penghuni',
                    'penjaga' => 'Penjaga',
                    'kasur' => 'Kasur',
                    'bantal' => 'Bantal',
                    'lemari' => 'Lemari',
                    'guling' => 'Guling',
                    'kursi' => 'Kursi',
                    'meja' => 'Meja',
                    'meja_rias' => 'Meja Rias',
                    'mesin_cuci' => 'Mesin Cuci',
                    'r_jemur' => 'Ruang Jemur',
                    'dapur' => 'Dapur'
                ] as $key => $label)
                    @if($kost->fasilitas->$key)
                        <li class="facility-item">{{ $label }}</li>
                    @endif
                @endforeach

                {{-- Fasilitas Custom --}}
                @if($kost->fasilitas->fasilitas_custom)
                    @foreach($kost->fasilitas->fasilitas_custom as $custom)
                        <li class="facility-item">{{ $custom }}</li>
                    @endforeach
                @endif
            </ul>
        </div>
        @endif

        @if($kost->images->count() > 0)
        <div class="section">
            <h2 class="section-title">Galeri Foto</h2>
            <div class="gallery">
                @foreach($kost->images as $image)
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Foto Kost" class="gallery-item">
                @endforeach
            </div>
        </div>
        @endif

        <div class="footer">
            Sistem Informasi Kost - Sabar Turu Mondok
        </div>
        
        <div class="no-print" style="margin-top: 30px; text-align: center;">
            <button onclick="window.print()" style="padding: 10px 20px; background: var(--primary); color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">Cetak Laporan</button>
        </div>
    </div>
</body>
</html>
