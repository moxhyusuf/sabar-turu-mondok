<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Monitoring Rumah Kos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }

        .kop-surat img {
            width: 100%;
            height: auto;
        }

        .report-title {
            background-color: #e8e8e8;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin: 20px 0;
            text-transform: uppercase;
        }

        .info-section {
            width: 100%;
            margin-bottom: 20px;
            font-size: 12px;
        }

        .info-table {
            width: 100%;
            border: none;
        }

        .info-table td {
            border: none;
            padding: 2px 0;
            text-align: left;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.data-table th, 
        table.data-table td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 10pt;
            text-align: center;
        }

        table.data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 11pt;
        }

        .footer p {
            margin: 5px 0;
        }

        .badge {
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 9pt;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="kop-surat">
            {{-- Menggunakan public_path untuk DomPDF agar gambar ter-load dengan benar --}}
            <img src="{{ public_path('dist/img/kop.png') }}" alt="Kop Surat">
        </div>

        <div class="report-title">Laporan Monitoring Rumah Kos</div>

        <table class="info-table">
            <tr>
                <td width="150">Tanggal Cetak</td>
                <td width="10">:</td>
                <td>{{ now()->format('d-m-Y') }}</td>
                <td align="right">Total Data: {{ $kosts->count() }}</td>
            </tr>
            <tr>
                <td>Periode / Filter</td>
                <td>:</td>
                <td colspan="2">
                    @if(request('from') && request('to'))
                        {{ \Carbon\Carbon::parse(request('from'))->format('d M Y') }} s/d {{ \Carbon\Carbon::parse(request('to'))->format('d M Y') }}
                    @else
                        Semua Waktu
                    @endif
                    {{ request('kelurahan') ? ' | Kelurahan: '.request('kelurahan') : '' }}
                    {{ request('status_izin') ? ' | Status: '.ucfirst(str_replace('_', ' ', request('status_izin'))) : '' }}
                </td>
            </tr>
        </table>

        <table class="data-table">
            <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Nama Kos</th>
                    <th>Pemilik</th>
                    <th>Kelurahan</th>
                    <th>Status Perizinan</th>
                    <th>Tanggal Input</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kosts as $index => $kost)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td align="left">{{ $kost->nama_kost }}</td>
                    <td align="left">{{ $kost->nama_pemilik }}</td>
                    <td>{{ $kost->kelurahan }}</td>
                    <td>
                        {{ $kost->status_izin == 'berizin' ? 'Berizin' : 'Belum Berizin' }}
                    </td>
                    <td>{{ $kost->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">Data tidak ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="summary" style="font-size: 10pt; margin-top: 10px;">
            <p><strong>Ringkasan:</strong></p>
            <ul>
                <li>Total Rumah Kos: {{ $kosts->count() }}</li>
                <li>Berizin: {{ $kosts->where('status_izin', 'berizin')->count() }}</li>
                <li>Belum Berizin: {{ $kosts->where('status_izin', 'belum_berizin')->count() }}</li>
            </ul>
        </div>

        <div class="footer">
            <p>Probolinggo, {{ now()->format('d F Y') }}</p>
            <p>Admin Kecamatan</p>
            <br><br><br>
            <p>_______________________</p>
        </div>
    </div>
</body>
</html>
