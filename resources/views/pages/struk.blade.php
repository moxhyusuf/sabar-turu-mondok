<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran - {{ $transaksi->booking->kode_booking }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #000;
            background-color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }
        .receipt-container {
            width: 80mm;
            padding: 10mm;
            border: 1px dashed #ccc;
            margin-top: 20px;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .font-bold {
            font-weight: bold;
        }
        .mb-1 { margin-bottom: 5px; }
        .mb-2 { margin-bottom: 10px; }
        .mt-2 { margin-top: 10px; }
        .divider {
            border-bottom: 1px dashed #000;
            margin: 10px 0;
        }
        .logo {
            width: 50px;
            height: auto;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            vertical-align: top;
            padding: 2px 0;
        }
        .label {
            width: 40%;
        }
        .colon {
            width: 5%;
            text-align: center;
        }
        .value {
            width: 55%;
            text-align: right;
        }
        
        @media print {
            body {
                background-color: transparent;
            }
            .receipt-container {
                border: none;
                margin-top: 0;
                padding: 0;
            }
            @page {
                size: 80mm auto;
                margin: 0;
            }
        }
    </style>
</head>
<body>

<div class="receipt-container">
    <div class="text-center mb-2">
        <h2 class="font-bold" style="margin: 0;">{{ $transaksi->kost->nama_kost }}</h2>
        <div>{{ $transaksi->kost->alamat }}, {{ $transaksi->kost->kelurahan }}</div>
        <div>WhatsApp: {{ $transaksi->kost->contact_person }}</div>
    </div>

    <div class="divider"></div>

    <table>
        <tr>
            <td class="label">Tanggal</td>
            <td class="colon">:</td>
            <td class="value">{{ now()->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td class="label">No. Transaksi</td>
            <td class="colon">:</td>
            <td class="value">TX-{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <td class="label">Kode Booking</td>
            <td class="colon">:</td>
            <td class="value">{{ $transaksi->booking->kode_booking }}</td>
        </tr>
        <tr>
            <td class="label">Kasir</td>
            <td class="colon">:</td>
            <td class="value">Sistem (Auto)</td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="font-bold text-center mb-2">DETAIL PENYEWAAN</div>

    <table>
        <tr>
            <td class="label">Nama Penyewa</td>
            <td class="colon">:</td>
            <td class="value font-bold">{{ strtoupper($transaksi->booking->penyewa->nama ?? '-') }}</td>
        </tr>
        <tr>
            <td class="label">Nama Kost</td>
            <td class="colon">:</td>
            <td class="value">{{ $transaksi->kost->nama_kost ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Check-in</td>
            <td class="colon">:</td>
            <td class="value">{{ \Carbon\Carbon::parse($transaksi->tanggal_masuk)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="label">Check-out</td>
            <td class="colon">:</td>
            <td class="value">{{ \Carbon\Carbon::parse($transaksi->tanggal_keluar)->format('d/m/Y') }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <table>
        <tr>
            <td class="label">Metode Pemb.</td>
            <td class="colon">:</td>
            <td class="value">{{ $transaksi->metode_pembayaran == 'cash' ? 'Cash / Tunai' : 'Transfer Bank' }}</td>
        </tr>
        <tr>
            <td class="label font-bold">Total</td>
            <td class="colon font-bold">:</td>
            <td class="value font-bold">Rp {{ number_format($transaksi->total_bayar > 0 ? $transaksi->total_bayar : $transaksi->kost->harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label font-bold">Status</td>
            <td class="colon font-bold">:</td>
            <td class="value font-bold" style="font-size: 14px;">LUNAS</td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="text-center mt-2" style="font-size: 10px;">
        <div>*** BUKTI PEMBAYARAN SAH ***</div>
        <div>Simpan struk ini sebagai bukti<br>pembayaran yang sah.</div>
        <div class="mt-2">Terima kasih atas kepercayaan Anda.</div>
    </div>
</div>

</body>
</html>
