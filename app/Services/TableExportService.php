<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use App\Exports\TableExport;

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
        return Excel::download(new TableExport($headers, $data), $filename);
    }
} 