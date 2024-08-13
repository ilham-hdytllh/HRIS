<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />
    <link href="{{ asset('assets/css/bootstrap-dark.min.css') }}" rel="stylesheet" type="text/css"
        id="bs-dark-stylesheet" disabled />
    <link href="{{ asset('assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="app-dark-stylesheet"
        disabled />

    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 18px;
        }

        .custom-card {
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            margin-bottom: 20px;
            padding: 16px;
        }

        .custom-card h4 {
            margin-top: 0;
        }

        .custom-card p {
            margin: 0;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .custom-card .label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
    </style>
</head>

<body>
    <div class="container p-4">
        <h3>Evaluasi Karyawan Baru</h3>
        <br>
        @foreach ($data_employe as $employe)
            <div class="custom-card">
                <p><span>Nama            :</span> {{ $employe['nama'] }}</p>
                <p><span>No Scan         :</span> {{ $employe['no_scan'] }}</p>
                <p><span>Departemen      :</span> {{ $employe['dept'] }}</p>
                <p><span>Tanggal Masuk   :</span> {{ $employe['tgl_masuk'] }}</p>
                <p><span>Tanggal Evaluasi:</span> {{ $employe['tgl_evaluasi'] }}</p>
                <p><span>Jabatan         :</span> {{ $employe['jabatan'] }}</p>
            </div>
            <br>
        @endforeach
    </div>
</body>

</html>
