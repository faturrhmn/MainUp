<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;

class TableExportService
{
    /**
     * Konversi data tabel ke PDF
     *
     * @param array $headers Header tabel
     * @param array $data Data tabel
     * @param string $filename Nama file output
     * @param array $options Opsi tambahan untuk view (misalnya data logo Base64)
     * @return \Illuminate\Http\Response
     */
    public function exportToPdf(array $headers, array $data, string $filename = 'export.pdf', array $options = [])
    {
        $pdf = PDF::loadView('exports.table-pdf', [
            'headers' => $headers,
            'data' => $data
        ], $options);

        return $pdf->download($filename);
    }

    /**
     * Konversi data tabel ke Excel
     *
     * @param array $headers Header tabel
     * @param array $data Data tabel
     * @param string $filename Nama file output
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportToExcel(array $headers, array $data, string $filename = 'export.xlsx')
    {
        $collection = new Collection($data);
        
        return Excel::download(new class($headers, $collection) implements \Maatwebsite\Excel\Concerns\FromCollection {
            protected $headers;
            protected $data;

            public function __construct($headers, $data)
            {
                $this->headers = $headers;
                $this->data = $data;
            }

            public function collection()
            {
                return $this->data;
            }

            public function headings(): array
            {
                return $this->headers;
            }
        }, $filename);
    }
} 