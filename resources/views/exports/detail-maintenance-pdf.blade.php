<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $judul ?? 'Detail Maintenance' }}</title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif; /* Menggunakan DejaVu Sans untuk support karakter non-ASCII */
            font-size: 12px;
            margin: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 80px;
        }

        .logo-container img {
            height: 35px;
            width: auto;
        }

        .kop {
            text-align: center;
            margin-bottom: 15px;
        }

        .kop h3 {
            font-size: 14px;
            font-weight: bold;
            margin: 0 0 5px 0;
        }

        .kop p {
            font-size: 12px;
            margin: 0;
        }

        .divider {
            border-bottom: 1px solid black;
            margin: 15px 0;
        }

        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin: 20px 0;
        }

        .header-table {
            width: 100%;
        }

        .header-table td {
            vertical-align: top;
            padding: 0; /* Removed horizontal padding */
        }

        .header-table .left-col {
            width: 20%;
            text-align: left;
            vertical-align: middle;
            padding-top: 0;
        }

        .header-table .center-col {
             width: 60%;
            text-align: center;
             vertical-align: top;
             padding-top: 0;
        }

        .header-table .right-col {
             width: 20%;
            text-align: right;
            vertical-align: middle;
             padding-top: 0;
        }

         .header-table img {
            width: 100px;
            height: auto;
             margin-top: 0;
             padding-top: 0;
             vertical-align: middle;
        }

        .content {
            margin-top: 5px;
        }

        .section-title {
            font-size: 16px; /* Slightly increased font size */
            font-weight: bold;
            margin-top: 20px; /* Increased margin */
            margin-bottom: 10px; /* Adjusted margin */
            padding-bottom: 5px;
            border-bottom: 1px solid #eee; /* Added subtle border */
            display: block;
            clear: both;
            width: 100%;
        }

        .data-row {
            margin-bottom: 8px; /* Increased margin */
            line-height: 1.5; /* Improved line height */
        }

        .data-row strong {
            display: inline-block;
            width: 180px; /* Increased width for labels */
            margin-right: 10px; /* Added margin */
        }

        .image-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: flex-start;
            margin: 20px 0;
        }

        .image-item {
            width: calc(50% - 10px);
            display: inline-block;
            vertical-align: top;
        }

        .image-item img {
            width: 100%;
            height: 200px;
            object-fit: contain;
            border: 1px solid #ddd;
            margin-bottom: 8px;
        }

        .image-caption {
            font-size: 11px;
            text-align: center;
            margin-top: 5px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .history-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-bottom: 20px;
        }

        .history-table th,
        .history-table td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
        }

        .history-table th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }

        .history-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .history-table tr:hover {
            background-color: #f0f0f0;
        }

        .footer {
            position: fixed;
            bottom: 30px;
            width: 100%;
            font-size: 10px;
            font-style: italic;
             text-align: center; /* Center footer text */
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo-container">
            @if(isset($logoRriBase64) && $logoRriBase64)
                <img src="{{ $logoRriBase64 }}" alt="Logo RRI">
            @else
                <img src="{{ asset('assets/rri.png') }}" alt="Logo RRI">
            @endif
            @if(isset($logoMainupBase64) && $logoMainupBase64)
                <img src="{{ $logoMainupBase64 }}" alt="Logo MainUp">
            @else
                <img src="{{ asset('assets/logo mainup.png') }}" alt="Logo MainUp">
            @endif
        </div>
        <div class="kop">
            <h3>LPP RRI BANDUNG</h3>
            <p>Jl. Diponegoro No.61, Bandung 40115 | Telp. (022) 4202294</p>
        </div>
        <div class="divider"></div>
        <div class="title">LAPORAN DETAIL MAINTENANCE</div>
    </div>

    <div class="content">
        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td style="width: 48%; vertical-align: top;">
                    <div class="section-title">Informasi Barang</div>
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 180px; font-weight: bold; padding: 4px 0;">No Asset:</td>
                            <td style="padding: 4px 0;">{{ $asset->nomor_aset ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="width: 180px; font-weight: bold; padding: 4px 0;">Nama Barang:</td>
                            <td style="padding: 4px 0;">{{ $asset->nama_barang ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="width: 180px; font-weight: bold; padding: 4px 0;">Merk:</td>
                            <td style="padding: 4px 0;">{{ $asset->merk ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="width: 180px; font-weight: bold; padding: 4px 0;">Tahun:</td>
                            <td style="padding: 4px 0;">{{ $asset->tahun ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="width: 180px; font-weight: bold; padding: 4px 0;">Jumlah:</td>
                            <td style="padding: 4px 0;">{{ $asset->jumlah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="width: 180px; font-weight: bold; padding: 4px 0;">Ruangan:</td>
                            <td style="padding: 4px 0;">{{ $asset->ruangan->nama_ruangan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="width: 180px; font-weight: bold; padding: 4px 0;">Tipe:</td>
                            <td style="padding: 4px 0;">{{ $asset->tipe ?? '-' }}</td>
                        </tr>
                        @php
                            $jadwal = $asset->jadwals->first();
                            $siklusLabel = '-';
                            if(isset($jadwal->siklus)) {
                                switch($jadwal->siklus) {
                                    case 'hari': $siklusLabel = 'Harian'; break;
                                    case 'minggu': $siklusLabel = 'Mingguan'; break;
                                    case 'bulan': $siklusLabel = 'Bulanan'; break;
                                    case '3_bulan': $siklusLabel = '3 Bulan'; break;
                                    case '6_bulan': $siklusLabel = '6 Bulan'; break;
                                    case '1_tahun': $siklusLabel = '1 Tahun'; break;
                                    default: $siklusLabel = ucfirst(str_replace('_', ' ', $jadwal->siklus)); break;
                                }
                            }
                        @endphp
                        <tr>
                            <td style="width: 180px; font-weight: bold; padding: 4px 0;">Siklus:</td>
                            <td style="padding: 4px 0;">{{ $siklusLabel }}</td>
                        </tr>
                        <tr>
                            <td style="width: 180px; font-weight: bold; padding: 4px 0;">Tanggal Mulai:</td>
                            <td style="padding: 4px 0;">{{ isset($jadwal->tanggal_mulai) ? \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('d-m-Y') : '-' }}</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 4%;"></td>
                <td style="width: 48%; vertical-align: top;">
                    <div class="section-title">Detail Maintenance</div>
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 180px; font-weight: bold; padding: 4px 0;">Tanggal Selesai:</td>
                            <td style="padding: 4px 0;">{{ isset($maintenance->tanggal_perbaikan) ? \Carbon\Carbon::parse($maintenance->tanggal_perbaikan)->format('d-m-Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td style="width: 180px; font-weight: bold; padding: 4px 0;">Status:</td>
                            <td style="padding: 4px 0;">{{ $maintenance->status ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="width: 180px; font-weight: bold; padding: 4px 0;">PIC:</td>
                            <td style="padding: 4px 0;">{{ $maintenance->pic ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="width: 180px; font-weight: bold; padding: 4px 0; vertical-align: top;">Teknisi:</td>
                            <td style="padding: 4px 0;">
                                @php
                                    $teknisiText = $maintenance->teknisi ?? '';
                                    $teknisiLines = array_map('trim', explode("\n", str_replace("\r", "", $teknisiText)));
                                    $teknisiFiltered = array_filter($teknisiLines, function($line) {
                                        return !empty($line) && $line != '-';
                                    });
                                @endphp
                                @if(count($teknisiFiltered) > 0)
                                    @foreach($teknisiFiltered as $teknisi)
                                        - {{ ltrim($teknisi, '-') }}<br>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- History Perbaikan di halaman pertama --}}
        <div class="section-title" style="margin-top: 30px;">History Perbaikan</div>
        @if($maintenance->history && $maintenance->history->isNotEmpty())
            <table class="history-table" style="margin-top: 10px;">
                <thead>
                    <tr>
                        <th style="width: 5%; text-align: center;">Tanggal Perbaikan</th>
                        <th style="width: 20%; text-align: center;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($maintenance->history->sortBy('created_at') as $historyItem)
                        <tr>
                            <td style="text-align: center;">{{ \Carbon\Carbon::parse($historyItem->tanggal_perbaikan)->format('d/m/Y') }}</td>
                            <td style="text-align: justify; padding: 8px 12px;">{{ $historyItem->keterangan ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada history perbaikan untuk maintenance ini.</p>
        @endif

        {{-- Section gambar selalu ditampilkan --}}
        <div style="page-break-before: always;"></div>
        
        <div class="section-title" style="margin-top: 20px;">Gambar Sebelum Perbaikan</div>
        <div class="image-container">
            @if(isset($beforeImages) && count($beforeImages) > 0)
                @foreach($beforeImages as $image)
                    @if(isset($image['base64']) && $image['base64'])
                        <div class="image-item">
                            <img src="{{ $image['base64'] }}" alt="Before Image">
                            @if(isset($image['keterangan']) && $image['keterangan'])
                                <div class="image-caption">{{ $image['keterangan'] }}</div>
                            @endif
                        </div>
                    @endif
                @endforeach
            @else
                <p style="width: 100%; text-align: center; padding: 20px;">Tidak ada gambar sebelum perbaikan.</p>
            @endif
        </div>

        @if(isset($beforeImages) && count($beforeImages) >= 4)
            <div style="page-break-before: always;"></div>
        @endif
        
        <div class="section-title" style="margin-top: 20px;">Gambar Setelah Perbaikan</div>
        <div class="image-container">
            @if(isset($afterImages) && count($afterImages) > 0)
                @foreach($afterImages as $image)
                    @if(isset($image['base64']) && $image['base64'])
                        <div class="image-item">
                            <img src="{{ $image['base64'] }}" alt="After Image">
                            @if(isset($image['keterangan']) && $image['keterangan'])
                                <div class="image-caption">{{ $image['keterangan'] }}</div>
                            @endif
                        </div>
                    @endif
                @endforeach
            @else
                <p style="width: 100%; text-align: center; padding: 20px;">Tidak ada gambar setelah perbaikan.</p>
            @endif
        </div>

        <div class="footer">
            Dokumen ini dicetak otomatis oleh sistem pada tanggal {{ \Carbon\Carbon::now()->format('d F Y H:i') }}. Harap tidak menandatangani secara manual.
        </div>
    </div>

</body>
</html> 