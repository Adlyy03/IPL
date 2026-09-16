<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blok;
use App\Models\Gang;
use App\Models\IuranWarga;
use App\Models\JenisIuran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    /**
     * Tampilkan halaman laporan dengan filter dan pagination.
     */
    public function index(Request $request): View
    {
        $query = $this->buildFilterQuery($request);

        $ringkasanLaporan = $this->hitungRingkasan($query);
        $daftarLaporan = $query->latest('id')->paginate(20)->withQueryString();

        $gangs = Gang::where('status', 'aktif')->orderBy('nama_gang')->get();
        $bloks = Blok::where('status', 'aktif')->with('gang')->orderBy('nama_blok')->orderBy('nomor_rumah')->get();
        $jenisIurans = JenisIuran::where('is_aktif', true)->orderBy('nama_iuran')->get();

        return view('admin.laporan.index', compact(
            'ringkasanLaporan',
            'daftarLaporan',
            'gangs',
            'bloks',
            'jenisIurans'
        ));
    }

    /**
     * Unduh laporan dalam format Excel (.xlsx).
     */
    public function exportExcel(Request $request): StreamedResponse
    {
        $query = $this->buildFilterQuery($request);
        $ringkasanLaporan = $this->hitungRingkasan($query);
        $daftarLaporan = $query->latest('id')->get();

        $spreadsheet = new Spreadsheet;
        $spreadsheet->getProperties()
            ->setCreator('IPL (Iuran Pengelolaan Lingkungan)')
            ->setTitle('Laporan Keuangan IPL')
            ->setSubject('Rekapitulasi Tagihan dan Pembayaran IPL');

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan IPL');

        // Judul Laporan
        $sheet->setCellValue('A1', 'LAPORAN IURAN PENGELOLAAN LINGKUNGAN (IPL)');
        $sheet->mergeCells('A1:K1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16)->setColor(new Color('FF1E293B'));
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Subtitle Periode & Tanggal Unduh
        $periodeText = $request->filled('periode') ? 'Periode: '.$request->periode : 'Periode: Semua Periode';
        $statusText = $request->filled('status_pembayaran') ? 'Status: '.ucfirst($request->status_pembayaran) : 'Status: Semua';
        $waktuCetak = 'Dicetak: '.now()->translatedFormat('d F Y, H:i').' WIB';
        $sheet->setCellValue('A2', "{$periodeText}  |  {$statusText}  |  {$waktuCetak}");
        $sheet->mergeCells('A2:K2');
        $sheet->getStyle('A2')->getFont()->setSize(10)->setItalic(true)->setColor(new Color('FF64748B'));
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Ringkasan KPI Header
        $sheet->setCellValue('A4', 'RINGKASAN LAPORAN');
        $sheet->mergeCells('A4:F4');
        $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(11);

        $kpiHeaders = ['Total Tagihan', 'Sudah Bayar (Lunas)', 'Menunggu Bayar', 'Total Nominal Tagihan', 'Total Terkumpul', 'Sisa Piutang'];
        $kpiValues = [
            $ringkasanLaporan['total_tagihan'].' data',
            $ringkasanLaporan['total_sudah_bayar'].' data',
            $ringkasanLaporan['total_belum_bayar'].' data',
            $ringkasanLaporan['total_nominal_tagihan'],
            $ringkasanLaporan['total_nominal_pembayaran'],
            $ringkasanLaporan['total_nominal_tagihan'] - $ringkasanLaporan['total_nominal_pembayaran'],
        ];

        for ($i = 0; $i < 6; $i++) {
            $colLetter = chr(65 + $i);
            $sheet->setCellValue($colLetter.'5', $kpiHeaders[$i]);
            $sheet->setCellValue($colLetter.'6', $kpiValues[$i]);
        }

        $sheet->getStyle('A5:F5')->getFont()->setBold(true)->setSize(9);
        $sheet->getStyle('A5:F5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF1F5F9');
        $sheet->getStyle('A5:F6')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('FFE2E8F0'));
        $sheet->getStyle('D6:F6')->getNumberFormat()->setFormatCode('#,##0');

        // Header Kolom Tabel Data
        $tableStartRow = 8;
        $headers = [
            'A' => 'No',
            'B' => 'No. Tagihan',
            'C' => 'Nama Warga',
            'D' => 'Blok & No. Rumah',
            'E' => 'Gang',
            'F' => 'Jenis Iuran',
            'G' => 'Periode',
            'H' => 'Nominal (Rp)',
            'I' => 'Status',
            'J' => 'Tanggal Bayar',
            'K' => 'Catatan',
        ];

        foreach ($headers as $col => $title) {
            $sheet->setCellValue($col.$tableStartRow, $title);
        }

        $sheet->getStyle('A'.$tableStartRow.':K'.$tableStartRow)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
                'size' => 10,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF312E81'], // Indigo 900
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getRowDimension($tableStartRow)->setRowHeight(26);

        // Isi Data Tabel
        $currentRow = $tableStartRow + 1;
        $no = 1;

        foreach ($daftarLaporan as $item) {
            $blokRumah = $item->warga?->blok ? ($item->warga->blok->nama_blok.' No. '.$item->warga->blok->nomor_rumah) : '-';
            $gangNama = $item->warga?->blok?->gang?->nama_gang ?? '-';
            $statusText = match ($item->status_pembayaran) {
                'lunas' => 'Lunas',
                'menunggu_pembayaran' => 'Menunggu Pembayaran',
                'batal' => 'Batal',
                default => ucfirst((string) $item->status_pembayaran),
            };

            $sheet->setCellValue('A'.$currentRow, $no++);
            $sheet->setCellValue('B'.$currentRow, '#IPL-'.str_pad($item->id, 5, '0', STR_PAD_LEFT));
            $sheet->setCellValue('C'.$currentRow, $item->warga?->nama_lengkap ?? '-');
            $sheet->setCellValue('D'.$currentRow, $blokRumah);
            $sheet->setCellValue('E'.$currentRow, $gangNama);
            $sheet->setCellValue('F'.$currentRow, $item->jenisIuran?->nama_iuran ?? '-');
            $sheet->setCellValue('G'.$currentRow, $item->periode);
            $sheet->setCellValue('H'.$currentRow, $item->nominal);
            $sheet->setCellValue('I'.$currentRow, $statusText);
            $sheet->setCellValue('J'.$currentRow, $item->tanggal_pembayaran ? $item->tanggal_pembayaran->format('d/m/Y H:i') : '-');
            $sheet->setCellValue('K'.$currentRow, $item->catatan ?? '-');

            // Format styling baris data
            $sheet->getStyle('A'.$currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B'.$currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('G'.$currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('H'.$currentRow)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('I'.$currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('J'.$currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Warna status
            if ($item->status_pembayaran === 'lunas') {
                $sheet->getStyle('I'.$currentRow)->getFont()->setColor(new Color('FF059669'));
            } else {
                $sheet->getStyle('I'.$currentRow)->getFont()->setColor(new Color('FFD97706'));
            }

            // Zebra striping ringan
            if ($no % 2 === 0) {
                $sheet->getStyle('A'.$currentRow.':K'.$currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFF8FAFC');
            }

            $currentRow++;
        }

        // Total Baris Bawah
        $sheet->setCellValue('A'.$currentRow, 'TOTAL');
        $sheet->mergeCells('A'.$currentRow.':G'.$currentRow);
        $sheet->getStyle('A'.$currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A'.$currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->setCellValue('H'.$currentRow, '=SUM(H'.($tableStartRow + 1).':H'.($currentRow - 1).')');
        $sheet->getStyle('H'.$currentRow)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('H'.$currentRow)->getFont()->setBold(true);

        // Border Tabel Lengkap
        $sheet->getStyle('A'.$tableStartRow.':K'.$currentRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('FFE2E8F0'));
        $sheet->getStyle('A'.$currentRow.':K'.$currentRow)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_DOUBLE);

        // Auto width kolom
        foreach (array_keys($headers) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'laporan-ipl-'.now()->format('Ymd-His').'.xlsx';

        return new StreamedResponse(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    /**
     * Unduh laporan dalam format PDF siap rapat RT/RW (.pdf).
     */
    public function exportPdf(Request $request)
    {
        $query = $this->buildFilterQuery($request);
        $ringkasanLaporan = $this->hitungRingkasan($query);
        $daftarLaporan = $query->latest('id')->get();

        $filters = [
            'periode' => $request->filled('periode') ? $request->periode : 'Semua Periode',
            'status' => $request->filled('status_pembayaran') ? ucfirst($request->status_pembayaran) : 'Semua Status',
            'jenis' => $request->filled('jenis_iuran_id') ? (JenisIuran::find($request->jenis_iuran_id)?->nama_iuran ?? '-') : 'Semua Jenis',
            'gang' => $request->filled('gang_id') ? (Gang::find($request->gang_id)?->nama_gang ?? '-') : 'Semua Gang',
        ];

        $tanggalCetak = now()->translatedFormat('d F Y, H:i');

        $pdf = Pdf::loadView('admin.laporan.pdf', compact(
            'daftarLaporan',
            'ringkasanLaporan',
            'filters',
            'tanggalCetak'
        ))->setPaper('a4', 'landscape');

        $filename = 'laporan-ipl-'.now()->format('Ymd-His').'.pdf';

        return $pdf->download($filename);
    }

    /**
     * Helper query filter iuran terpadu.
     */
    protected function buildFilterQuery(Request $request): Builder
    {
        $query = IuranWarga::with(['warga.blok.gang', 'jenisIuran']);

        if ($request->filled('periode')) {
            $query->where('periode', $request->periode);
        }

        if ($request->filled('jenis_iuran_id')) {
            $query->where('jenis_iuran_id', $request->jenis_iuran_id);
        }

        if ($request->filled('gang_id')) {
            $query->whereHas('warga.blok', function ($q) use ($request) {
                $q->where('gang_id', $request->gang_id);
            });
        }

        if ($request->filled('blok_id')) {
            $query->whereHas('warga', function ($q) use ($request) {
                $q->where('blok_id', $request->blok_id);
            });
        }

        if ($request->filled('status_pembayaran')) {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }

        return $query;
    }

    /**
     * Helper hitung agregat ringkasan laporan.
     *
     * @return array<string, int|float>
     */
    protected function hitungRingkasan(Builder $query): array
    {
        return [
            'total_tagihan' => (clone $query)->count(),
            'total_sudah_bayar' => (clone $query)->where('status_pembayaran', 'lunas')->count(),
            'total_belum_bayar' => (clone $query)->where('status_pembayaran', 'menunggu_pembayaran')->count(),
            'total_nominal_tagihan' => (float) (clone $query)->sum('nominal'),
            'total_nominal_pembayaran' => (float) (clone $query)->where('status_pembayaran', 'lunas')->sum('nominal'),
        ];
    }
}
