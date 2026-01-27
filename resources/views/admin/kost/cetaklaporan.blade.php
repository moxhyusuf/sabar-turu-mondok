<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kost</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
            padding-bottom: 20px;
            gap: 15px;
        }

        .logo img {
            width: 70px;
            height: 70px;
        }

        .header-text {
            flex: 1;
            text-align: center;
        }

        .header-text h1 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .header-text .address {
            font-size: 11px;
        }

        .report-title {
            background-color: #e8e8e8;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .info-item {
            font-size: 14px;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
        }

        .print-button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        @media print {

            .print-button,
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <!-- Tombol Cetak -->
    <button class="print-button" onclick="window.print()">🖨️ Cetak Laporan</button>

    <div class="container">

        <div class="kop-surat" style="text-align: center;">
            <img src="{{ asset('dist/img/kop.png') }}" alt="Kop Surat" style="width: 95%;">
        </div>


        <div class="report-title">LAPORAN DATA KOST</div>

        <div class="info-section">
            <div>
                <div class="info-item">Tanggal Cetak: {{ $tanggal_cetak }}</div>
                <div class="info-item">Cetak Berdasarkan: {{ $filter_kost ?? 'Semua' }}</div>
            </div>

            <div>
                <div class="info-item">Total Data: {{ $data->count() }}</div>
            </div>
        </div>


        <table class="table table-bordered table-hover">
            <thead class="table-secondary">
                <tr>
                    <th class="text-center">No</th>

                    <th>Nama Kost</th>
                    <th>Pemilik</th>
                    <th>Kontak</th>
                    <th>Alamat</th>
                    <th>Jumlah Kamar</th>
                    <th>NIB</th>

                </tr>
            </thead>

            <tbody>
                @forelse ($data as $key => $item)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>



                    {{-- NAMA KOST --}}
                    <td>
                        {{ $item->nama_kost }}
                        <span class="badge bg-success">{{ ucfirst($item->jenis_kost) }}</span>

                    </td>

                    {{-- PEMILIK --}}
                    <td>
                        {{ $item->nama_pemilik }}<br>

                    </td>

                    {{-- KONTAK --}}
                    <td>

                        {{ $item->contact_person }}

                    </td>

                    {{-- ALAMAT --}}
                    <td>
                        {{ $item->alamat }}<br>

                    </td>

                    {{-- JUMLAH KAMAR --}}
                    <td class="text-center">
                        {{ $item->jumlah_kamar }}
                    </td>

                    {{-- NIB --}}
                    <td class="text-center">
                        @if($item->nib)
                        {{ $item->nib }}
                        @else
                        <span class="badge bg-secondary">Belum Ada</span>
                        @endif
                    </td>


                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Belum ada data kost.</td>
                </tr>
                @endforelse
            </tbody>
        </table>



        <div class="footer">
            <p>Probolinggo, {{ $tanggal_cetak }}</p>
            <p>Penanggung Jawab</p>
            <br><br>
            <p>_______________________</p>
        </div>

    </div>

    <!-- Tombol Kembali Pojok Kanan Atas -->
    <button onclick="window.location.href='{{ route('kost.index') }}'"
        class="no-print"
        style="
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        ">
        Kembali
    </button>

</body>

</html>
