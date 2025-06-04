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
            border-bottom: 2px solid black;
            padding-top: 10px; /* Increased padding */
            padding-bottom: 10px; /* Increased padding */
            margin-bottom: 15px; /* Increased margin */
        }

        .kop {
            text-align: center;
            margin-top: 0;
            margin-bottom: 0;
        }

        .kop h3, .kop h4, .kop p {
            margin: 2px 0; /* Adjusted margin */
            padding: 0;
            line-height: 1.4; /* Adjusted line height */
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
            margin-top: 20px; /* Increased margin */
             text-align: center; /* Center images */
        }

        .image-item {
            display: inline-block;
            margin: 0 15px 15px 0; /* Adjusted margin for grid-like layout */
            padding: 8px; /* Increased padding */
            text-align: center;
             vertical-align: top; /* Align items to the top */
        }

        .image-item img {
            max-width: 180px; /* Adjusted max width */
            height: 130px; /* Adjusted fixed height for consistency */
            display: block;
            margin-bottom: 8px; /* Adjusted margin */
             object-fit: cover;
        }

        .image-caption {
            font-size: 10px;
            text-align: center;
            margin-top: 4px; /* Adjusted margin */
            word-break: break-word;
             max-width: 180px; /* Constrain caption width */
        }

        .history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .history-table th,
        .history-table td {
            border: 1px solid #000;
            padding: 10px; /* Increased padding */
            text-align: left;
             vertical-align: top; /* Align content to top */
             font-size: 11px; /* Slightly smaller font for table content */
        }

         .history-table th {
            background-color: #f2f2f2; /* Added light background to header */
            font-weight: bold;
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
        <table class="header-table">
            <tr>
                <td class="left-col">
                    {{-- Menggunakan data Base64 untuk Logo RRI --}}
                    @if(isset($logoRriBase64) && $logoRriBase64)
                        <img src="{{ $logoRriBase64 }}" alt="Logo RRI" style="width: 120px; height: auto;">
                    @else
                        <img src="{{ asset('assets/rri.png') }}" alt="Logo RRI" style="width: 120px; height: auto;">
                    @endif
                </td>
                <td class="center-col">
                     <div class="kop">
                        <h3>LPP RADIO REPUBLIK INDONESIA</h3>
                        <h4>RRI BANDUNG</h4>
                        <p>Jl. Diponegoro No. 61, Bandung 40115 | Telp. (022) 4202294</p>
                    </div>
                </td>
                <td class="right-col">
                    {{-- Menggunakan data Base64 untuk Logo MainUp --}}
                    @if(isset($logoMainupBase64) && $logoMainupBase64)
                        <img src="{{ $logoMainupBase64 }}" alt="Logo MainUp" style="width: 120px; height: auto;">
                    @else
                        <img src="{{ asset('assets/logo mainup.png') }}" alt="Logo MainUp" style="width: 120px; height: auto;">
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="content">
        <h4 style="text-align: center; margin-bottom: 20px;">{{ $judul ?? 'Laporan Detail Maintenance' }}</h4>
        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td style="width: 48%; vertical-align: top;">
                    <div class="section-title">Informasi Barang</div>
                    {{-- Gunakan tabel untuk tata letak yang rapi --}}
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 180px; font-weight: bold; padding: 4px 0;">ID Barang:</td>
                            <td style="padding: 4px 0;">{{ $asset->id_aset ?? '-' }}</td>
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
                         <tr>
                            <td style="width: 180px; font-weight: bold; padding: 4px 0;">Keterangan:</td>
                            <td style="padding: 4px 0;">{{ $asset->keterangan ?? '-' }}</td>
                        </tr>
                    </table>

                </td>
                <td style="width: 4%;"></td>
                <td style="width: 48%; vertical-align: top;">
                    <div class="section-title">Detail Maintenance</div>
                    <div class="data-row"><strong>Tanggal Perbaikan:</strong> {{ $maintenance->tanggal_perbaikan ?? '-' }}</div>
                    <div class="data-row"><strong>Status:</strong> {{ $maintenance->status ?? '-' }}</div>
                    <div class="data-row"><strong>PIC:</strong> {{ $maintenance->pic ?? '-' }}</div>
                    <div class="data-row">
                        <strong>Teknisi:</strong><br>
                        @php
                            $teknisiText = $maintenance->teknisi ?? '';
                            $teknisiLines = array_map('trim', explode("\n", str_replace("\r", "", $teknisiText)));
                            // Filter empty lines and remove leading hyphen and space if present
                            $teknisiFiltered = array_filter($teknisiLines, function($line) {
                                return !empty($line) && $line != '-';
                            });
                            $teknisiFormatted = array_map(function($line) {
                                // Remove leading hyphen and space if present
                                return preg_replace('/^-\s*/', '', $line);
                            }, $teknisiFiltered);
                        @endphp

                        @if(count($teknisiFormatted) > 0)
                            @foreach($teknisiFormatted as $teknisi)
                                - {{ $teknisi }}<br>
                            @endforeach
                        @else
                            -
                        @endif
                    </div>
                </td>
            </tr>
           
        </table>
        {{-- Calculate total number of images --}}
        @php
            $totalImages = count($beforeImages) + count($afterImages);
        @endphp

        {{-- Page break before beforeImages section if needed (optional, based on previous content) --}}
        <div style="page-break-before: always;"></div>

        <div class="section-title" style="margin-top: 20px;">Gambar Sebelum Perbaikan</div>
        <div style="width:100%;height:1px;clear:both;"></div>
        <div class="image-container">
            @forelse($beforeImages as $image)
                @if(isset($image['base64']) && $image['base64'])
                    <div class="image-item">
                        <img src="{{ $image['base64'] }}" alt="Before Image">
                        @if(isset($image['keterangan']) && $image['keterangan'])
                            <div class="image-caption">{{ $image['keterangan'] }}</div>
                        @endif
                    </div>
                @else
                    <div class="image-item">
                        <p>Gambar tidak tersedia</p>
                        @if(isset($image['keterangan']) && $image['keterangan'])
                            <div class="image-caption">{{ $image['keterangan'] }}</div>
                        @endif
                    </div>
                @endif
            @empty
                <p>Tidak ada gambar sebelum perbaikan.</p>
            @endforelse
        </div>

        {{-- Add page break before afterImages only if total images are 8 or more --}}
        @if($totalImages >= 8)
            <div style="page-break-before: always;"></div>
        @endif

        <div class="section-title" style="margin-top: 20px;">Gambar Setelah Perbaikan</div>
        <div style="width:100%;height:1px;clear:both;"></div>
        <div class="image-container">
            @forelse($afterImages as $image)
                @if(isset($image['base64']) && $image['base64'])
                    <div class="image-item">
                        <img src="{{ $image['base64'] }}" alt="After Image">
                        @if(isset($image['keterangan']) && $image['keterangan'])
                            <div class="image-caption">{{ $image['keterangan'] }}</div>
                        @endif
                    </div>
                @else
                    <div class="image-item">
                        <p>Gambar tidak tersedia</p>
                        @if(isset($image['keterangan']) && $image['keterangan'])
                            <div class="image-caption">{{ $image['keterangan'] }}</div>
                        @endif
                    </div>
                @endif
            @empty
                <p>Tidak ada gambar setelah perbaikan.</p>
            @endforelse
        </div>

        {{-- Halaman baru untuk History Perbaikan --}}
        <div style="page-break-before: always;"></div>
        <div class="section-title" style="margin-top: 20px;">History Perbaikan</div>
        <div style="width:100%;height:1px;clear:both;"></div>

        @if($maintenance->history && $maintenance->history->isNotEmpty())
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Tanggal Perbaikan</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($maintenance->history->sortBy('created_at') as $historyItem)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($historyItem->tanggal_perbaikan)->format('d/m/Y') }}</td>
                            <td>{{ $historyItem->keterangan ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada history perbaikan untuk maintenance ini.</p>
        @endif
    </div>

    <div class="footer">
        Dokumen ini dicetak otomatis oleh sistem pada tanggal {{ \Carbon\Carbon::now()->format('d F Y H:i') }}. Harap tidak menandatangani secara manual.
    </div>

</body>
</html> 