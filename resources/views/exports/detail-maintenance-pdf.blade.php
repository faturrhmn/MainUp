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
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .kop {
            text-align: center;
        }

        .kop h3, .kop h4, .kop p {
            margin: 0;
            padding: 0;
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
        }

        .header-table .center-col {
             width: 60%;
            text-align: center;
        }

        .header-table .right-col {
             width: 20%;
            text-align: right;
        }

        .header-table img {
            width: 80px;
            height: auto;
        }

        .content {
            margin-top: 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
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
            border: 1px solid #ddd;
            padding: 5px;
            text-align: center;
        }

        .image-item img {
            max-width: 150px;
            height: auto;
            display: block;
            margin-bottom: 5px;
        }

        .image-caption {
            font-size: 10px;
            text-align: center;
        }

        .footer {
            position: fixed;
            bottom: 30px;
            text-align: center;
            width: 100%;
            font-size: 10px;
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
                        <img src="{{ $logoRriBase64 }}" alt="Logo RRI" style="width: 100px; height: auto;">
                    @else
                        <img src="{{ asset('assets/rri.png') }}" alt="Logo RRI">
                    @endif
                </td>
                <td class="center-col">
                     <div class="kop" style="margin-top: 10px;">
                        <h3>LPP RADIO REPUBLIK INDONESIA</h3>
                        <h4>RRI BANDUNG</h4>
                        <p>Jl. Diponegoro No. 61, Bandung 40115 | Telp. (022) 4202294</p>
                    </div>
                </td>
                <td class="right-col">
                    {{-- Menggunakan data Base64 untuk Logo MainUp --}}
                    @if(isset($logoMainupBase64) && $logoMainupBase64)
                        <img src="{{ $logoMainupBase64 }}" alt="Logo MainUp" style="width: 100px; height: auto;">
                    @else
                        <img src="{{ asset('assets/logo mainup.png') }}" alt="Logo MainUp">
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="content">
        <h4 style="text-align: center;">{{ $judul ?? 'Laporan Detail' }}</h4>

        <div class="section-title">Informasi Barang</div>
        <div class="data-row"><strong>Nama Barang:</strong> {{ $asset->nama_barang ?? '-' }}</div>
        <div class="data-row"><strong>Merk:</strong> {{ $asset->merk ?? '-' }}</div>
        <div class="data-row"><strong>Tahun:</strong> {{ $asset->tahun ?? '-' }}</div>

        <div class="section-title">Detail Maintenance</div>
        <div class="data-row"><strong>Tanggal Perbaikan:</strong> {{ $maintenance->tanggal_perbaikan ?? '-' }}</div>
        <div class="data-row"><strong>Status:</strong> {{ $maintenance->status ?? '-' }}</div>
        <div class="data-row"><strong>PIC:</strong> {{ $maintenance->pic ?? '-' }}</div>
        <div class="data-row"><strong>Teknisi:</strong> {{ $maintenance->teknisi ?? '-' }}</div>
        <div class="data-row"><strong>Keterangan:</strong> {{ $maintenance->keterangan ?? '-' }}</div>

        <div class="section-title">Gambar Sebelum Perbaikan</div>
        <div class="image-container">
            @forelse($beforeImages as $image)
                @if(isset($image['base64']) && $image['base64'])
                    <div class="image-item">
                        {{-- Menggunakan data Base64 --}}
                        <img src="{{ $image['base64'] }}" alt="Before Image">
                        <div class="image-caption">{{ $image['keterangan'] ?? '-' }}</div>
                    </div>
                @else
                     {{-- Tampilkan placeholder atau pesan jika gambar Base64 null/tidak ada --}}
                    <div class="image-item">
                         <p>Gambar tidak tersedia</p>
                         <div class="image-caption">{{ $image['keterangan'] ?? '-' }}</div>
                    </div>
                @endif
            @empty
                <p>Tidak ada gambar sebelum perbaikan.</p>
            @endforelse
        </div>

        <div class="section-title">Gambar Setelah Perbaikan</div>
         <div class="image-container">
            @forelse($afterImages as $image)
                 @if(isset($image['base64']) && $image['base64'])
                    <div class="image-item">
                        {{-- Menggunakan data Base64 --}}
                        <img src="{{ $image['base64'] }}" alt="After Image">
                        <div class="image-caption">{{ $image['keterangan'] ?? '-' }}</div>
                    </div>
                @else
                     {{-- Tampilkan placeholder atau pesan jika gambar Base64 null/tidak ada --}}
                     <div class="image-item">
                         <p>Gambar tidak tersedia</p>
                          <div class="image-caption">{{ $image['keterangan'] ?? '-' }}</div>
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