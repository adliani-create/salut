<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lembar Informasi Pembayaran Registrasi</title>
    <style>
        @page {
            margin: 40px 50px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.4;
            font-size: 14px;
            position: relative;
        }
        /* Header Section */
        .header-table {
            width: 100%;
            margin-bottom: 5px;
        }
        .header-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .header-subtitle {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }
        .header-right {
            text-align: right;
        }
        .text-salut {
            color: #0d6efd; /* Blue SALUT */
            font-size: 24px;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .info-contact {
            font-size: 12px;
            color: #555;
        }
        
        .divider {
            border-bottom: 2px solid #333;
            margin-bottom: 30px;
        }

        /* Information Section */
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            vertical-align: top;
        }
        .info-left {
            width: 60%;
        }
        .info-right {
            width: 40%;
            text-align: right;
        }

        .student-details {
            width: 100%;
        }
        .student-details td {
            padding: 3px 0;
            font-size: 14px;
        }
        .col-label {
            width: 130px;
            font-weight: bold;
        }
        .col-colon {
            width: 15px;
        }

        /* Billing Information Right */
        .billing-title {
            text-align: right;
            font-size: 14px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .rek-no {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* The Main Table */
        .table-invoice {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 20px;
            border: 2px solid #000;
        }
        .table-invoice th, .table-invoice td {
            border: 1px solid #000;
            padding: 12px;
            font-size: 14px;
        }
        .table-invoice th {
            background-color: #000;
            color: #fff;
            text-align: center;
        }
        .table-invoice td:first-child {
            padding-left: 15px;
        }
        .table-invoice td.price {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 250px;
            left: 50%;
            /* Transformation logic for DomPDF */
            transform: translate(-50%, 0) rotate(-35deg);
            font-size: 130px;
            font-weight: bold;
            color: #28a745; /* Bootstrap Success Green */
            opacity: 0.2;
            z-index: -1;
            letter-spacing: 15px;
        }

        /* Footer */
        .footer-table {
            width: 100%;
            margin-top: 40px;
        }
        .tenggat {
            text-align: right;
            font-weight: bold;
        }
        .tenggat span {
            color: #dc3545; /* Red */
        }
        
        .signature-section {
            margin-top: 30px;
        }
        .signature-title {
            margin-bottom: 5px;
        }
        .signature-name {
            margin-top: 70px;
            font-weight: bold;
            text-decoration: underline;
        }

    </style>
</head>
<body>

    <!-- Watermark Background -->
    <div class="watermark">LUNAS</div>

    <!-- Header Content -->
    <table class="header-table">
        <tr>
            <td style="vertical-align: top;">
                <div class="header-title">LEMBAR INFORMASI PEMBAYARAN</div>
                <div class="header-subtitle">REGISTRASI SALUT INDO GLOBAL</div>
            </td>
            <td class="header-right">
                @if(!empty($logo_base64))
                    <img src="{{ $logo_base64 }}" alt="Logo SALUT" style="max-height: 85px; max-width: 250px; object-fit: contain; margin-bottom: 5px;">
                @else
                    <span class="text-salut">SALUT</span>
                @endif
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    <!-- Student and Billing Info -->
    <table class="info-table">
        <tr>
            <td class="info-left">
                <div style="font-weight:bold; margin-bottom:15px;">NAMA MAHASISWA</div>
                <div style="font-weight:bold; font-size: 18px; margin-bottom:15px;">{{ $nama }}</div>
                
                <table class="student-details">
                    <tr>
                        <td class="col-label">NIM</td><td class="col-colon">:</td><td>{{ $nim }}</td>
                    </tr>
                    <tr>
                        <td class="col-label">Program Studi</td><td class="col-colon">:</td><td>{{ $prodi }}</td>
                    </tr>
                    <tr>
                        <td class="col-label">Masa Registrasi</td><td class="col-colon">:</td><td>{{ $masa_registrasi }}</td>
                    </tr>
                    <tr>
                        <td class="col-label">Semester</td><td class="col-colon">:</td><td>{{ $semester }}</td>
                    </tr>
                </table>
            </td>
            
            <td class="info-right">
                <div class="billing-title">INFO PEMBAYARAN</div>
                
                <div style="margin-bottom: 5px; font-weight:bold;">No Rekening BTN :</div>
                <div class="rek-no">0054801880000212</div>
                <div style="margin-bottom: 20px; font-weight:bold;">a/n Salut Indo Global</div>
                
                <div><span style="font-weight:bold">No. Ref:</span> {{ $no_ref }}</div>
            </td>
        </tr>
    </table>

    <!-- Main Payment Table -->
    <table class="table-invoice">
        <thead>
            <tr>
                <th style="width: 70%;">Deskripsi</th>
                <th style="width: 30%;">Biaya</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Biaya Layanan SALUT INDO GLOBAL</td>
                <td class="price">Rp.500.000,-</td>
            </tr>
        </tbody>
    </table>

    <!-- Footer Information -->
    <table class="footer-table">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%;" class="tenggat">Tenggat Pembayaran: <span>TELAH LUNAS</span></td>
        </tr>
    </table>

    <!-- Signature -->
    <div class="signature-section" style="position: relative; text-align: right;">
        @if(!empty($signature_base64))
            <div style="margin-top: 10px; margin-bottom: 5px;">
                <img src="{{ $signature_base64 }}" alt="Tanda Tangan" style="max-height: 160px; max-width: 280px; object-fit: contain;">
            </div>
        @else
            <div class="signature-name" style="margin-top: 70px;">&nbsp;</div>
        @endif
    </div>

</body>
</html>
