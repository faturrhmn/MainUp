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
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .logo {
            float: left;
            width: 80px;
            margin-right: 20px; /* Tambahkan margin agar tidak terlalu dekat dengan teks kop */
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
                        {{-- Tampilkan placeholder jika Base64 tidak tersedia --}}
                        Logo RRI
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
                        {{-- Tampilkan placeholder jika Base64 tidak tersedia --}}
                        Logo MainUp
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="content">
        <h4 style="text-align: center;">{{ $judul ?? 'Laporan Tabel' }}</h4>

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