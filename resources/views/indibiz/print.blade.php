<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Indibiz - Telda Labuan Bajo</title>
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: #1a1a1a;
            background-color: #ffffff;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px double #1a1a1a;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1b5394;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 11px;
            color: #4b5563;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .title {
            text-align: center;
            margin-bottom: 25px;
        }
        .title h2 {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .title p {
            margin: 5px 0 0 0;
            font-size: 11px;
            color: #374151;
        }
        .metadata-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .metadata-table td {
            padding: 3px 0;
        }
        .metadata-table td.label {
            width: 120px;
            font-weight: 600;
            color: #4b5563;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 30px;
        }
        .data-table th, .data-table td {
            border: 1px solid #1a1a1a;
            padding: 8px 10px;
            text-align: left;
        }
        .data-table th {
            background-color: #f3f4f6;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            border: 1px solid #1a1a1a;
            border-radius: 3px;
        }
        .badge-aktif {
            background-color: #e2f9df;
            color: #1e4620;
            border-color: #bbf7d0;
        }
        .badge-nonaktif {
            background-color: #fee2e2;
            color: #7f1d1d;
            border-color: #fecaca;
        }
        .footer {
            margin-top: 50px;
            width: 100%;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }
        .signature-title {
            margin-bottom: 60px;
        }
        .signature-name {
            font-weight: 700;
            text-decoration: underline;
        }
        .signature-role {
            font-size: 10px;
            color: #4b5563;
            margin-top: 2px;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
            @page {
                size: A4 portrait;
                margin: 15mm;
            }
        }
        .btn-print-box {
            background: #f3f4f6;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #e5e7eb;
        }
        .btn-print {
            background-color: #1b5394;
            color: white;
            border: none;
            padding: 6px 16px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .btn-print:hover {
            background-color: #154175;
        }
        .btn-close {
            background-color: #4b5563;
            color: white;
            border: none;
            padding: 6px 16px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 12px;
            text-decoration: none;
        }
        .btn-close:hover {
            background-color: #374151;
        }
    </style>
</head>
<body>

    <div class="btn-print-box no-print">
        <span style="font-weight: 600; color: #374151;">Pratinjau Laporan Klien Indibiz</span>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('indibiz.index') }}" class="btn-close">Kembali</a>
            <button onclick="window.print()" class="btn-print">Cetak Laporan</button>
        </div>
    </div>

    <div class="header">
        <h1>Telda Labuan Bajo</h1>
        <p>Sistem Manajemen Operasional & Penjualan Layanan Telkom - NTT</p>
    </div>

    <div class="title">
        <h2>Laporan Data Klien Indibiz</h2>
        <p>Dicetak pada: {{ now()->setTimezone('Asia/Makassar')->format('d F Y H:i') }} WITA</p>
    </div>

    <table class="metadata-table">
        <tr>
            <td class="label">Bulan Periode</td>
            <td>: {{ $filterBulan ?? 'Semua Bulan' }}</td>
            <td class="label">Tahun Periode</td>
            <td>: {{ $filterTahun ?? 'Semua Tahun' }}</td>
        </tr>
        <tr>
            <td class="label">Tipe Layanan</td>
            <td>: <span style="text-transform: uppercase; font-weight: 600;">{{ $filterTipe ?? 'Semua Layanan' }}</span></td>
            <td class="label">Jumlah Rekaman</td>
            <td>: {{ count($items) }} data ditemukan</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%; text-align: center;">No</th>
                <th style="width: 25%;">Nama Perusahaan</th>
                <th style="width: 33%;">Alamat Lengkap</th>
                <th style="width: 15%;">Tipe Layanan</th>
                <th style="width: 13%; text-align: center;">Status</th>
                <th style="width: 10%; text-align: right;">Tanggal Input</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $index => $item)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="font-weight: 700;">{{ $item->nama_perusahaan }}</td>
                    <td>{{ $item->alamat_perusahaan }}</td>
                    <td style="font-weight: 600; text-transform: uppercase;">{{ $item->jenis_layanan }}</td>
                    <td style="text-align: center;">
                        @php
                            $badgeClass = strtolower($item->status_langganan) == 'aktif' ? 'badge-aktif' : 'badge-nonaktif';
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $item->status_langganan }}</span>
                    </td>
                    <td style="text-align: right;">{{ optional($item->tanggal_input)->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 30px; font-style: italic; color: #6b7280;">Tidak ada data yang sesuai dengan filter pencarian.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <table class="signature-table">
            <tr>
                <td>
                    <div class="signature-title">Mengetahui,</div>
                    <div class="signature-name">_______________________</div>
                    <div class="signature-role">Pimpinan Telda Labuan Bajo</div>
                </td>
                <td>
                    <div class="signature-title">Labuan Bajo, {{ now()->setTimezone('Asia/Makassar')->format('d F Y') }}</div>
                    <div class="signature-name">{{ auth()->user()->nama_lengkap }}</div>
                    <div class="signature-role">Petugas Log / {{ auth()->user()->role }}</div>
                </td>
            </tr>
        </table>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>
