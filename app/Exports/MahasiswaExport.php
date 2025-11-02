<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MahasiswaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $keyword;
    private $no = 0;

    public function __construct($keyword = null)
    {
        $this->keyword = $keyword;
    }

    public function collection()
    {
        return Mahasiswa::when($this->keyword, function ($query) {
                $query->where('nama', 'like', "%{$this->keyword}%")
                      ->orWhere('nim', 'like', "%{$this->keyword}%")
                      ->orWhere('email', 'like', "%{$this->keyword}%");
            })
            ->orderBy('nama', 'asc')
            ->get();
    }

    public function map($mahasiswa): array
    {
        $this->no++;

        return [
            $this->no,
            $mahasiswa->nama,
            $mahasiswa->nim,
            $mahasiswa->email,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'NIM',
            'Email',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Styling header
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '4F81BD'], // Biru
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        // Border semua cell
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Kolom No rata tengah
        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');

        // Tinggi baris header
        $sheet->getRowDimension(1)->setRowHeight(25);

        return [];
    }

    // ✅ Tambahkan fungsi ini untuk menentukan nama file
    public static function fileName()
    {
        return 'Laporan Data Mahasiswa.xlsx';
    }
}
