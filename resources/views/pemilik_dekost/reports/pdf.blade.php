<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pemilik Kos</title>
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
            font-size: 9pt;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="kop-surat">
            <img src="{{ public_path('dist/img/kop.png') }}" alt="Kop Surat">
        </div>

        <div class="report-title">Laporan Kondisi Kos & Riwayat Penghuni</div>

        <table class="info-table">
            <tr>
                <td width="150">Pemilik / User</td>
                <td width="10">:</td>
                <td>{{ auth()->user()->nama }}</td>
                <td align="right">Tanggal Cetak: {{ now()->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td>Filter Periode</td>
                <td>:</td>
                <td colspan="2">
                    @if(request('from') && request('to'))
                        {{ \Carbon\Carbon::parse(request('from'))->format('d M Y') }} s/d {{ \Carbon\Carbon::parse(request('to'))->format('d M Y') }}
                    @else
                        Semua Waktu
                    @endif
                    {{ request('status') ? ' | Status: '.ucfirst(request('status')) : '' }}
                </td>
            </tr>
        </table>

        <table class="data-table">
            <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Nama Penyewa</th>
                    <th>Kost</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Keluar</th>
                    <th>Status</th>
                    <th>Tanggal Transaksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $index => $t)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td align="left">{{ $t->booking->penyewa->nama ?? 'N/A' }}</td>
                    <td align="left">{{ $t->kost->nama_kost ?? 'N/A' }}</td>
                    <td>{{ $t->booking->tanggal_masuk ?? 'N/A' }}</td>
                    <td>{{ $t->tanggal_keluar ?? 'N/A' }}</td>
                    <td>{{ ucfirst($t->status) }}</td>
                    <td>{{ $t->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">Data tidak ditemukan</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            <p>Probolinggo, {{ now()->format('d F Y') }}</p>
            <p>Pemilik Kos</p>
            <br><br><br>
            <p>_______________________</p>
            <p>{{ auth()->user()->nama }}</p>
        </div>
    </div>
</body>
</html>
