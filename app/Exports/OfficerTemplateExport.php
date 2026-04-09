<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OfficerTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function headings(): array {
        return ['NIK', 'Email', 'Nama']; // Baris 1
    }

    public function array(): array {
        return [
            // Baris 2: Instruksi
            ['PENTING:', 'JANGAN HAPUS BARIS INI, ISI DATA MULAI BARIS KE-3', ''],
            // Baris 3: Contoh data
            ['2021234567', 'jaya@jtrustbank.co.id', 'Jaya']
        ];
    }

    public function styles(Worksheet $sheet) {
        return [
            // Baris 1: Header Kuning (Opsional)
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'FFFF00']]],
            // Baris 2: Background MERAH, teks PUTIH (Sesuai Gambar Anda)
            2 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'FF0000']]
            ],
        ];
    }
}