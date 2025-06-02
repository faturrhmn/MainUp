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
            padding-top: 5px;
            padding-bottom: 3px;
            margin-bottom: 0px;
        }

        .kop {
            text-align: center;
            margin-top: 0;
            margin-bottom: 0;
        }

        .kop h3, .kop h4, .kop p {
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }

        .header-table {
            width: 100%;
        }

        .header-table td {
            vertical-align: top;
            padding: 0;
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
            font-size: 14px;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 22px;
            padding-bottom: 5px;
            display: block;
            clear: both;
            width: 100%;
        }

        .data-row {
            margin-bottom: 5px;
        }

        .data-row strong {
            display: inline-block;
            width: 150px; /* Adjust as needed for alignment */
        }

        .image-container {
            margin-top: 15px;
        }

        .image-item {
            display: inline-block;
            margin-right: 15px;
            margin-bottom: 15px;
            padding: 5px;
            text-align: center;
        }

        .image-item img {
            max-width: 150px;
            height: auto;
            display: block;
            margin-bottom: 12px;
        }

        .image-caption {
            font-size: 10px;
            text-align: center;
            margin-top: 8px;
            word-break: break-word;
        }

        .footer {
            position: fixed;
            bottom: 30px;
            width: 100%;
            font-size: 10px;
            font-style: italic;
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
        <h4 style="text-align: center; margin-bottom: 10px;">{{ $judul ?? 'Laporan Detail Maintenance' }}</h4>
        <table style="width: 100%; margin-bottom: 10px;">
            <tr>
                <td style="width: 48%; vertical-align: top;">
                    <div class="section-title">Informasi Barang</div>
                    <div class="data-row"><strong>ID Barang:</strong> {{ $asset->id_aset ?? '-' }}</div>
                    <div class="data-row"><strong>Nama Barang:</strong> {{ $asset->nama_barang ?? '-' }}</div>
                    <div class="data-row"><strong>Merk:</strong> {{ $asset->merk ?? '-' }}</div>
                    <div class="data-row"><strong>Tahun:</strong> {{ $asset->tahun ?? '-' }}</div>
                    <div class="data-row"><strong>Jumlah:</strong> {{ $asset->jumlah ?? '-' }}</div>
                    <div class="data-row"><strong>Ruangan:</strong> {{ $asset->ruangan->nama_ruangan ?? '-' }}</div>
                    <div class="data-row"><strong>Tipe:</strong> {{ $asset->tipe ?? '-' }}</div>
                    <div class="data-row"><strong>Keterangan:</strong> {{ $asset->keterangan ?? '-' }}</div>
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
                    <div class="data-row"><strong>Siklus:</strong> {{ $siklusLabel }}</div>
                    <div class="data-row"><strong>Tanggal Mulai:</strong> {{ isset($jadwal->tanggal_mulai) ? \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format('d-m-Y') : '-' }}</div>
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
            <tr>
                <td colspan="3" style="vertical-align: top;">
                    <div class="data-row">
                        <strong>Keterangan:</strong><br>
                        <span style="text-align: justify; display: block;">{{ $maintenance->keterangan ?? '-' }}</span>
                    </div>
                </td>
            </tr>
        </table>
        <div style="page-break-before: always;"></div>
        <div class="section-title" style="margin-top: 20px;">Gambar Sebelum Perbaikan</div>
        <div style="width:100%;height:1px;clear:both;"></div>
        <div class="image-container">
            @forelse($beforeImages as $image)
                @if(isset($image['base64']) && $image['base64'])
                    <div class="image-item" style="max-width: 200px;">
                        <img src="{{ $image['base64'] }}" alt="Before Image" style="max-width: 200px; height: 150px; object-fit: cover;">
                        @if(isset($image['keterangan']) && $image['keterangan'])
                            <div class="image-caption">{{ $image['keterangan'] }}</div>
                        @endif
                    </div>
                @else
                    <div class="image-item" style="max-width: 200px;">
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
        <div style="page-break-before: always;"></div>
        <div class="section-title" style="margin-top: 20px;">Gambar Setelah Perbaikan</div>
        <div style="width:100%;height:1px;clear:both;"></div>
        <div class="image-container">
            @forelse($afterImages as $image)
                @if(isset($image['base64']) && $image['base64'])
                    <div class="image-item" style="max-width: 200px;">
                        <img src="{{ $image['base64'] }}" alt="After Image" style="max-width: 200px; height: 150px; object-fit: cover;">
                        @if(isset($image['keterangan']) && $image['keterangan'])
                            <div class="image-caption">{{ $image['keterangan'] }}</div>
                        @endif
                    </div>
                @else
                    <div class="image-item" style="max-width: 200px;">
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
    </div>

    <div class="footer">
        Dokumen ini dicetak otomatis oleh sistem pada tanggal {{ \Carbon\Carbon::now()->format('d F Y H:i') }}. Harap tidak menandatangani secara manual.
    </div>

</body>
</html> 