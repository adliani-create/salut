<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->id }} - SALUT Indo Global</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
            background: #fff;
        }
        @media print {
            body { background: #fff; }
            .invoice-box { box-shadow: none; border: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="invoice-box">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                 <img src="{{ asset('images/logo-salut.png') }}" alt="Logo" style="width:100%; max-width:200px;">
            </div>
            <div class="text-end">
                <h2 class="fw-bold text-primary">INVOICE</h2>
                <h5 class="text-muted">#INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</h5>
            </div>
        </div>
        
        <hr>

        <div class="row mb-4">
            <div class="col-6">
                <h6 class="fw-bold">Billed To:</h6>
                <p class="mb-0">{{ $invoice->user->name }}</p>
                <p class="mb-0">{{ $invoice->user->email }}</p>
                <p class="mb-0">NIM: {{ $invoice->user->nim ?? '-' }}</p>
            </div>
            <div class="col-6 text-end">
                <h6 class="fw-bold">Payment Details:</h6>
                <p class="mb-0">Status: <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : 'danger' }}">{{ ucfirst($invoice->status) }}</span></p>
                <p class="mb-0">Due Date: {{ $invoice->due_date->format('d M Y') }}</p>
                @if($invoice->paid_at)
                <p class="mb-0">Paid Date: {{ $invoice->paid_at->format('d M Y') }}</p>
                @endif
            </div>
        </div>

        <table class="table table-bordered mb-4">
            <thead class="table-light">
                <tr>
                    <th>Description</th>
                    <th class="text-end">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $invoice->title }}</td>
                    <td class="text-end">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="text-end fw-bold">Total</td>
                    <td class="text-end fw-bold">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="text-center mt-5 mb-3">
            <p class="text-muted small">Thank you for your payment.</p>
        </div>

        <div class="text-center no-print mt-4">
            <button onclick="window.print()" class="btn btn-primary btn-lg rounded-pill"><i class="bi bi-printer"></i> Print Invoice</button>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        // Auto print prompt
        // window.print();
    }
</script>
</body>
</html>
