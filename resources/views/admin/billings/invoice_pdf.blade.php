<!DOCTYPE html>
<html>
<head>
    <title>Invoice {{ $billing->billing_code }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header-title {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            width: 60%;
            display: inline-block;
            vertical-align: top;
        }
        .logo-section {
            width: 38%;
            display: inline-block;
            text-align: right;
            vertical-align: top;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            vertical-align: top;
            padding: 3px 0;
        }
        .label {
            width: 130px;
            font-weight: bold;
        }
        .separator {
            width: 20px;
        }
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 2px solid #000;
        }
        .content-table th {
            background-color: #000;
            color: #fff;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }
        .content-table td {
            border: 1px solid #000;
            padding: 15px;
            text-align: center;
        }
        .amount {
            font-weight: bold;
            font-size: 16px;
        }
        .footer-section {
            width: 100%;
            margin-top: 30px;
        }
        .signature {
            width: 40%;
            display: inline-block;
            text-align: left;
            vertical-align: top;
        }
        .due-date {
            width: 58%;
            display: inline-block;
            text-align: right;
            vertical-align: top;
            font-weight: bold;
        }
        .stamp-placeholder {
            margin-top: 10px;
            height: 80px;
            width: 150px;
            /* background-color: #f0f0f0; */
            border: 1px dashed #ccc; /* Placeholder for image */
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
        }
        .watermark {
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            font-weight: bold;
            opacity: 0.2;
            z-index: -1;
            border: 5px solid;
            padding: 20px;
        }
        .paid { color: green; border-color: green; }
        .unpaid { color: red; border-color: red; }
    </style>
</head>
<body>

    @if($billing->status == 'paid')
        <div class="watermark paid">LUNAS</div>
    @else
        <div class="watermark unpaid">TAGIHAN</div>
    @endif

    <div class="header">
        <div class="header-title">
            LEMBAR INFORMASI PEMBAYARAN<br>
            REGISTRASI SALUT INDO GLOBAL
        </div>
        <div class="logo-section">
            <!-- Text Logo Placeholder since we don't have the image file path correctly mapped yet -->
            <h2 style="margin:0; color:#0d6efd;">SALUT</h2>
            <small>Sentra Layanan UT</small><br>
            <strong>SALUT INDO GLOBAL</strong><br>
            Kota Tasikmalaya
        </div>
    </div>

    <!-- Student Info & Bank Info -->
    <table style="width: 100%;">
        <tr>
            <td style="width: 60%; vertical-align: top;">
                <div style="font-weight: bold; margin-bottom: 5px;">NAMA MAHASISWA</div>
                <div style="font-size: 18px; font-weight: bold; text-transform: uppercase; margin-bottom: 10px;">
                    {{ $billing->user->name }}
                </div>
                <table class="info-table">
                    <tr>
                        <td class="label">NIM</td>
                        <td class="separator">:</td>
                        <td>{{ $billing->user->nim ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Program Studi</td>
                        <td class="separator">:</td>
                        <td>{{ $billing->user->major ?? $billing->user->registration->prodi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Masa Registrasi</td>
                        <td class="separator">:</td>
                        <td>{{ date('Y') }} {{ ($billing->semester % 2 == 0) ? 'Genap' : 'Ganjil' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Semester</td>
                        <td class="separator">:</td>
                        <td>Semester {{ $billing->semester }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 40%; vertical-align: top; text-align: right;">
                <div style="margin-bottom: 10px;">INFO PEMBAYARAN</div>
                <div style="font-weight: bold; font-size: 14px;">No Rekening BTN :</div>
                <div style="font-size: 18px; font-weight: bold; margin: 5px 0;">0054801880000212</div>
                <div style="font-weight: bold;">a/n Salut Indo Global</div>
                
                <div style="margin-top: 20px;">
                    <strong>No. Ref:</strong> {{ $billing->billing_code }}
                </div>
            </td>
        </tr>
    </table>

    <!-- Billing Detail -->
    <table class="content-table">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th style="width: 30%;">Biaya</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: left; padding: 20px;">
                    Biaya {{ $billing->category ?? 'Jasa Layanan' }} SALUT INDO GLOBAL
                    @if($billing->description)
                        <br><small class="text-muted">({{ $billing->description }})</small>
                    @endif
                </td>
                <td class="amount">Rp.{{ number_format($billing->amount, 0, ',', '.') }},-</td>
            </tr>
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer-section">
        <div class="signature">
            Hormat kami,<br>
            <strong>Kepala SALUT Indo Global</strong>
            
            <div style="height: 80px; margin-top:10px; margin-bottom:5px;">
                  <!-- Use absolute path or base64 if needed for images in dompdf -->
                  <!-- Ideally we would have a signature image here -->
                  <div style="font-family: 'Courier New', monospace; color: #000; border: 1px solid #eee; padding: 10px; display:inline-block;">
                      [Stamp & Sig]
                  </div>
            </div>

            <div style="font-weight: bold; text-decoration: underline;">Willy Ramadhan, S.Pd.</div>
        </div>
        <div class="due-date">
            Tenggat Pembayaran: <span style="color: #d9534f;">{{ $billing->due_date ? $billing->due_date->format('d F Y') : '-' }}</span>
        </div>
    </div>

</body>
</html>
