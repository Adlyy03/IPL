<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan IPL</title>
    <style>
        @page {
            margin: 1.2cm 1.5cm;
            size: a4 landscape;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 9pt;
            line-height: 1.3;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        .header h1 {
            margin: 0;
            font-size: 14pt;
            font-weight: bold;
            color: #0f172a;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0 0 0;
            font-size: 8.5pt;
            color: #64748b;
        }
        .sub-header {
            margin-bottom: 14px;
        }
        .sub-header table {
            width: 100%;
            font-size: 8.5pt;
        }
        .sub-header td {
            padding: 2px 0;
        }
        .kpi-container {
            width: 100%;
            margin-bottom: 14px;
            border-collapse: collapse;
        }
        .kpi-box {
            border: 1px solid #cbd5e1;
            background-color: #f8fafc;
            padding: 6px 10px;
            text-align: center;
            width: 16.66%;
        }
        .kpi-label {
            font-size: 7pt;
            text-transform: uppercase;
            color: #64748b;
            font-weight: bold;
            margin-bottom: 3px;
        }
        .kpi-value {
            font-size: 9.5pt;
            font-weight: bold;
            color: #0f172a;
        }
        .text-emerald { color: #059669; }
        .text-amber { color: #d97706; }
        
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.data-table th {
            background-color: #1e293b;
            color: #ffffff;
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
            padding: 6px 5px;
            border: 1px solid #0f172a;
            text-align: center;
        }
        table.data-table td {
            padding: 5px 6px;
            border: 1px solid #cbd5e1;
            font-size: 8pt;
        }
        table.data-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .badge {
            display: inline-block;
            padding: 2px 5px;
            font-size: 7pt;
            font-weight: bold;
            border-radius: 3px;
            text-align: center;
        }
        .badge-success { background-color: #d1fae5; color: #065f46; }
        .badge-warning { background-color: #fef3c7; color: #92400e; }
        .badge-danger { background-color: #fee2e2; color: #991b1b; }
        
        .footer-signatures {
            margin-top: 20px;
            page-break-inside: avoid;
            width: 100%;
        }
        .sig-col {
            width: 40%;
            text-align: center;
            vertical-align: top;
            font-size: 8.5pt;
        }
        .sig-space {
            height: 55px;
        }
        .sig-name {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Kop Surat -->
    <div class="header">
        <h1>Laporan Rekapitulasi Iuran Pengelolaan Lingkungan (IPL)</h1>
        <p>Sistem Administrasi dan Keuangan Warga Lingkungan RT / RW Mandiri</p>
    </div>

    <!-- Metadata Filter & Tanggal Cetak -->
    <div class="sub-header">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 50%;">
                    <strong>Periode:</strong> {{ $filters['periode'] }} &nbsp;|&nbsp; 
                    <strong>Jenis Iuran:</strong> {{ $filters['jenis'] }}
                </td>
                <td style="width: 50%; text-align: right;">
                    <strong>Wilayah:</strong> {{ $filters['gang'] }} &nbsp;|&nbsp;
                    <strong>Status:</strong> {{ $filters['status'] }} &nbsp;|&nbsp;
                    <strong>Tanggal Cetak:</strong> {{ $tanggalCetak }}
                </td>
            </tr>
        </table>
    </div>

    <!-- KPI Ringkasan Box -->
    <table class="kpi-container" cellpadding="0" cellspacing="0">
        <tr>
            <td class="kpi-box">
                <div class="kpi-label">Total Tagihan</div>
                <div class="kpi-value">{{ $ringkasanLaporan['total_tagihan'] }}</div>
            </td>
            <td class="kpi-box">
                <div class="kpi-label">Sudah Bayar</div>
                <div class="kpi-value text-emerald">{{ $ringkasanLaporan['total_sudah_bayar'] }}</div>
            </td>
            <td class="kpi-box">
                <div class="kpi-label">Menunggu Bayar</div>
                <div class="kpi-value text-amber">{{ $ringkasanLaporan['total_belum_bayar'] }}</div>
            </td>
            <td class="kpi-box">
                <div class="kpi-label">Total Tagihan (Rp)</div>
                <div class="kpi-value">Rp {{ number_format($ringkasanLaporan['total_nominal_tagihan'], 0, ',', '.') }}</div>
            </td>
            <td class="kpi-box">
                <div class="kpi-label">Terkumpul (Rp)</div>
                <div class="kpi-value text-emerald">Rp {{ number_format($ringkasanLaporan['total_nominal_pembayaran'], 0, ',', '.') }}</div>
            </td>
            <td class="kpi-box">
                <div class="kpi-label">Sisa Piutang (Rp)</div>
                <div class="kpi-value text-amber">Rp {{ number_format($ringkasanLaporan['total_nominal_tagihan'] - $ringkasanLaporan['total_nominal_pembayaran'], 0, ',', '.') }}</div>
            </td>
        </tr>
    </table>

    <!-- Data Table -->
    <table class="data-table" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 10%;">Kode</th>
                <th style="width: 16%; text-align: left; padding-left: 6px;">Nama Warga</th>
                <th style="width: 13%; text-align: left; padding-left: 6px;">Blok / Rumah</th>
                <th style="width: 11%; text-align: left; padding-left: 6px;">Gang</th>
                <th style="width: 13%; text-align: left; padding-left: 6px;">Jenis Iuran</th>
                <th style="width: 8%;">Periode</th>
                <th style="width: 10%; text-align: right; padding-right: 6px;">Nominal (Rp)</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 10%;">Tgl Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($daftarLaporan as $index => $item)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="text-align: center; font-family: monospace; font-size: 7.5pt;">#IPL-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td><strong>{{ $item->warga?->nama_lengkap ?? '-' }}</strong></td>
                    <td>{{ $item->warga?->blok ? ($item->warga->blok->nama_blok . ' No. ' . $item->warga->blok->nomor_rumah) : '-' }}</td>
                    <td>{{ $item->warga?->blok?->gang?->nama_gang ?? '-' }}</td>
                    <td>{{ $item->jenisIuran?->nama_iuran ?? '-' }}</td>
                    <td style="text-align: center; font-family: monospace;">{{ $item->periode }}</td>
                    <td style="text-align: right; font-weight: bold;">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td style="text-align: center;">
                        @if ($item->status_pembayaran === 'lunas')
                            <span class="badge badge-success">Lunas</span>
                        @elseif ($item->status_pembayaran === 'menunggu_pembayaran')
                            <span class="badge badge-warning">Menunggu</span>
                        @else
                            <span class="badge badge-danger">Batal</span>
                        @endif
                    </td>
                    <td style="text-align: center; font-size: 7.5pt;">
                        {{ $item->tanggal_pembayaran ? $item->tanggal_pembayaran->format('d/m/Y') : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" style="text-align: center; padding: 15px; color: #64748b;">
                        Tidak ada data transaksi iuran yang sesuai dengan kriteria filter.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if ($daftarLaporan->isNotEmpty())
            <tfoot>
                <tr style="background-color: #f1f5f9; font-weight: bold;">
                    <td colspan="7" style="text-align: right; padding-right: 10px;">TOTAL:</td>
                    <td style="text-align: right;">Rp {{ number_format($daftarLaporan->sum('nominal'), 0, ',', '.') }}</td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        @endif
    </table>

    <!-- Tanda Tangan Pengesahan Rapat RT/RW -->
    <table class="footer-signatures" cellpadding="0" cellspacing="0">
        <tr>
            <td class="sig-col">
                <p>Mengetahui,<br><strong>Ketua RT / RW Lingkungan</strong></p>
                <div class="sig-space"></div>
                <p class="sig-name">( .................................................. )</p>
            </td>
            <td style="width: 20%;"></td>
            <td class="sig-col">
                <p>Dilaporkan oleh,<br><strong>Bendahara / Pengurus Kas</strong></p>
                <div class="sig-space"></div>
                <p class="sig-name">( {{ auth()->user()->name ?? 'Pengurus Lingkungan' }} )</p>
            </td>
        </tr>
    </table>

</body>
</html>
