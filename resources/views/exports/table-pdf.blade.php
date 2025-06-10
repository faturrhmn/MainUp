<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $judul ?? 'Laporan Tabel' }}</title>
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
            overflow: hidden; /* Untuk clear float */
        }

        .kop h3, .kop h4, .kop p {
            margin: 0;
            padding: 0;
        }

        .content {
            margin-top: 20px;
        }

        .footer {
            position: fixed;
            bottom: 30px;
            text-align: center;
            width: 100%;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            word-wrap: break-word; /* Tambahkan ini untuk handle teks panjang */
            overflow-wrap: break-word; /* Tambahkan ini untuk handle teks panjang */
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Added CSS to remove header table borders */
        .header-table {
            border-collapse: collapse;
            border: none;
            width: 100%;
        }

        .header-table td {
            border: none;
            padding: 5px;
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
            <p>Jl. Diponegoro No.61, Cihaur Geulis, Kec. Cibeunying Kaler, Kota Bandung, Jawa Barat 40122</p>
        </div>
        <div style="border-bottom: 1px solid black; margin: 15px 0;"></div>
        <div style="text-align: center; font-size: 14px; font-weight: bold; margin: 20px 0;">{{ $judul ?? 'Laporan Tabel' }}</div>
    </div>

    <div class="content">
        <table>
            <thead>
                <tr>
                    @foreach($headers as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                    <tr>
                        @foreach($row as $cell)
                            <td>{{ $cell }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        Dokumen ini dicetak otomatis oleh sistem pada tanggal {{ \Carbon\Carbon::now()->format('d F Y H:i') }}. Harap tidak menandatangani secara manual.
    </div>

</body>
</html> 