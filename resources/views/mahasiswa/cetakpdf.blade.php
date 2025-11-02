<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Mahasiswa</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            margin: 30px;
        }
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #444;
            padding: 8px 10px;
        }
        th {
            background-color: #4F81BD;
            color: white;
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #eaf1fb;
        }
        td {
            vertical-align: middle;
        }
        td:first-child {
            text-align: center;
            width: 5%;
        }
        .footer {
            text-align: right;
            font-size: 11px;
            margin-top: 25px;
            color: #555;
        }
        .header-info {
            text-align: center;
            font-size: 13px;
            color: #555;
            margin-bottom: 5px;
        }
        hr {
            border: 1px solid #2c3e50;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h2>📋 Laporan Data Mahasiswa</h2>
    <div class="header-info">
        Dicetak oleh sistem pada: {{ date('d M Y, H:i') }}
    </div>
    <hr>

    @if($mahasiswa->isEmpty())
        <p style="text-align:center; color:red;">Belum ada data mahasiswa untuk ditampilkan.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mahasiswa as $index => $m)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $m->nama }}</td>
                        <td>{{ $m->nim }}</td>
                        <td>{{ $m->email }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        Dicetak pada: {{ date('d-m-Y H:i:s') }}
    </div>
</body>
</html>
