<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $judul }}</title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
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

        .content {
            margin-top: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 5px;
            vertical-align: top;
        }

        .info-table td:first-child {
            width: 150px;
            font-weight: bold;
        }

        .maintenance-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .maintenance-table th,
        .maintenance-table td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 11px;
        }

        .maintenance-table th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }

        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            color: white;
            display: inline-block;
        }

        .badge-warning {
            background-color: #ffc107;
        }

        .badge-success {
            background-color: #28a745;
        }

        .footer {
            position: fixed;
            bottom: 30px;
            width: 100%;
            font-size: 10px;
            font-style: italic;
            text-align: center;
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
        <div class="title">{{ $judul }}</div>
    </div>

    <div class="content">
        <div class="section">
            <div class="section-title">Informasi Barang</div>
            <table class="info-table">
                <tr>
                    <td>No Aset</td>
                    <td>: {{ $asset->nomor_aset ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Nama Barang</td>
                    <td>: {{ $asset->nama_barang }}</td>
                </tr>
                <tr>
                    <td>Merk</td>
                    <td>: {{ $asset->merk }}</td>
                </tr>
                <tr>
                    <td>Tahun</td>
                    <td>: {{ $asset->tahun }}</td>
                </tr>
                <tr>
                    <td>Tipe Barang</td>
                    <td>: {{ $asset->tipe }}</td>
                </tr>
                <tr>
                    <td>Jumlah</td>
                    <td>: {{ $asset->jumlah }}</td>
                </tr>
                <tr>
                    <td>Ruangan</td>
                    <td>: {{ $asset->ruangan->nama_ruangan }}</td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>: {{ $asset->keterangan }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">History Maintenance</div>
            @if($asset->maintenance && $asset->maintenance->isNotEmpty())
                <table class="maintenance-table">
                    <thead>
                        <tr>
                            <th>Tanggal Perbaikan</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asset->maintenance as $maintenance)
                            <tr>
                                <td style="text-align: center;">
                                    {{ $maintenance->tanggal_perbaikan ? \Carbon\Carbon::parse($maintenance->tanggal_perbaikan)->format('d/m/Y') : '-' }}
                                </td>
                                <td style="text-align: center;">
                                    @if($maintenance->status == 'proses')
                                        <span class="badge badge-warning">Proses</span>
                                    @else
                                        <span class="badge badge-success">Selesai</span>
                                    @endif
                                </td>
                                <td>{{ $maintenance->keterangan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; color: #666;">Belum ada history maintenance untuk barang ini.</p>
            @endif
        </div>
    </div>

    <div class="footer">
        Dokumen ini dicetak otomatis oleh sistem pada tanggal {{ \Carbon\Carbon::now()->format('d F Y H:i') }}. Harap tidak menandatangani secara manual.
    </div>
</body>
</html> 