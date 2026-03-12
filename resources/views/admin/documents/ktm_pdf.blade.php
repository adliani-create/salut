<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Tanda Mahasiswa - {{ $user->name }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #feba00; /* UT Yellow */
        }
        .ktm-card {
            width: 100%;
            height: 100%;
            position: relative;
            background: #fff;
            border: 2px solid #0056b3; /* UT Blue */
            box-sizing: border-box;
            overflow: hidden;
        }
        .header {
            background-color: #0056b3;
            color: #fff;
            padding: 5px;
            text-align: center;
            height: 35px;
        }
        .header-logo {
            float: left;
            height: 25px;
            margin-left: 5px;
            margin-top: 5px;
        }
        .header-text {
            display: inline-block;
            margin-top: 5px;
        }
        .header-text h3 {
            margin: 0;
            font-size: 11px;
            font-weight: bold;
            line-height: 1.2;
            letter-spacing: 0.5px;
        }
        .header-text p {
            margin: 0;
            font-size: 7px;
            color: #feba00;
        }
        .content {
            padding: 10px;
        }
        .photo-area {
            float: right;
            width: 65px;
            height: 85px;
            border: 1px solid #ccc;
            text-align: center;
            background-color: #f9f9f9;
        }
        .photo-area img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .details-area {
            float: left;
            width: 180px;
            font-size: 9px;
            line-height: 1.4;
        }
        .details-table {
            width: 100%;
        }
        .details-table td {
            vertical-align: top;
        }
        .label {
            font-weight: bold;
            width: 50px;
        }
        .colon {
            width: 5px;
        }
        .value {
            font-weight: bold;
            color: #0056b3;
        }
        
        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #feba00;
            height: 12px;
            text-align: right;
        }
        .footer-text {
            color: #0056b3;
            font-size: 7px;
            font-weight: bold;
            margin-right: 10px;
            line-height: 12px;
        }
        
        /* Subtle watermark inside */
        .watermark {
            position: absolute;
            top: 50px;
            left: 20px;
            width: 200px;
            opacity: 0.05;
            z-index: 0;
        }
        
        /* Clearfix */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>
    <div class="ktm-card">
        @if($logoBase64)
            <img src="{{ $logoBase64 }}" class="watermark" alt="Watermark">
        @endif
        
        <div class="header clearfix">
            @if($logoBase64)
                <img src="{{ $logoBase64 }}" class="header-logo" alt="Logo">
            @endif
            <div class="header-text">
                <h3>KARTU TANDA MAHASISWA</h3>
                <p>SALUT INDO GLOBAL TASIKMALAYA</p>
            </div>
        </div>
        
        <div class="content clearfix" style="position: relative; z-index: 1;">
            <div class="photo-area">
                @if($photoBase64)
                    <img src="{{ $photoBase64 }}" alt="Foto Mahasiswa">
                @else
                    <div style="padding-top: 30px; font-size: 8px; color: #999;">FOTO 3x4</div>
                @endif
            </div>
            
            <div class="details-area">
                <table class="details-table">
                    <tr>
                        <td class="label">NAMA</td>
                        <td class="colon">:</td>
                        <td class="value">{{ strtoupper(str_replace('_', ' ', $user->name)) }}</td>
                    </tr>
                    <tr>
                        <td class="label">NIM</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $user->nim ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">PROGRAM</td>
                        <td class="colon">:</td>
                        <td class="value">{{ strtoupper($user->major ?? '-') }}</td>
                    </tr>
                    <tr>
                        <td class="label">SEMESTER</td>
                        <td class="colon">:</td>
                        <td class="value">{{ $user->semester ?? '1' }}</td>
                    </tr>
                </table>
                <div style="margin-top: 10px; font-size: 7px;">
                    * Kartu ini berlaku selama menjadi mahasiswa aktif.
                </div>
            </div>
        </div>
        
        <div class="footer">
            <div class="footer-text">www.salut-indoglobal.com</div>
        </div>
    </div>
</body>
</html>
