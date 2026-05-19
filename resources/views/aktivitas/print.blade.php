<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Log Aktivitas - Telda Labuan Bajo</title>
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
        <span style="font-weight: 600; color: #374151;">Pratinjau Laporan Log Aktivitas Sistem</span>
        <div style="display: flex; gap: 8px;">
            <a href="{{ route('aktivitas.index') }}" class="btn-close">Kembali</a>
            <button onclick="window.print()" class="btn-print">Cetak Laporan</button>
        </div>
    </div>

    <div class="header">
        <h1>Telda Labuan Bajo</h1>
        <p>Sistem Manajemen Operasional & Penjualan Layanan Telkom - NTT</p>
    </div>

    <div class="title">
        <h2>Laporan Log Aktivitas Sistem</h2>
        <p>Dicetak pada: {{ now()->setTimezone('Asia/Makassar')->format('d F Y H:i') }} WITA</p>
    </div>

    <div style="margin-bottom: 15px; font-weight: 600;">
        Total Rekaman Log: {{ count($items) }} data
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%; text-align: center;">No</th>
                <th style="width: 18%;">Waktu & Tanggal</th>
                <th style="width: 20%;">Pengguna</th>
                <th style="width: 25%;">Aksi / Modul</th>
                <th style="width: 33%;">Keterangan Aktivitas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $index => $item)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>
                        <div style="font-weight: 600;">{{ optional($item->tanggal_aktivitas)->format('d M Y') }}</div>
                        <div style="font-size: 10px; color: #4b5563;">{{ optional($item->tanggal_aktivitas)->format('H:i') }} WITA</div>
                    </td>
                    <td>
                        <div style="font-weight: 700;">{{ $item->pengguna?->nama_lengkap ?? 'Sistem' }}</div>
                        <div style="font-size: 9px; color: #4b5563; text-transform: uppercase;">{{ $item->pengguna?->role ?? 'Sistem' }}</div>
                    </td>
                    <td style="font-weight: 600; color: #1b5394;">{{ $item->nama_aktivitas }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 30px; font-style: italic; color: #6b7280;">Tidak ada log aktivitas sistem tercatat.</td>
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
                    <div class="signature-role">Administrator Sistem / {{ auth()->user()->role }}</div>
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
