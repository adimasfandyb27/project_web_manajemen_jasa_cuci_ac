<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            font-size: 11px;
            padding: 25px;
        }

        .header {
            border-bottom: 3px solid #059669;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .company-table {
            width: 100%;
        }

        .company-table td {
            border: none;
            vertical-align: middle;
        }

        .logo {
            width: 70px;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #059669;
        }

        .company-info {
            color: #6b7280;
            font-size: 10px;
            margin-top: 4px;
            line-height: 1.5;
        }

        .report-title {
            text-align: center;
            margin: 25px 0;
        }

        .report-title h2 {
            font-size: 22px;
            color: #111827;
        }

        .report-title p {
            color: #6b7280;
            margin-top: 5px;
        }

        .summary {
            margin-bottom: 20px;
        }

        .summary-table {
            width: 100%;
        }

        .summary-table td {
            width: 20%;
            border: 1px solid #e5e7eb;
            padding: 12px;
            text-align: center;
        }

        .summary-label {
            color: #6b7280;
            font-size: 10px;
        }

        .summary-value {
            font-size: 16px;
            font-weight: bold;
            margin-top: 4px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table.data-table th {
            background: #059669;
            color: white;
            padding: 10px;
            border: 1px solid #047857;
            text-align: left;
        }

        table.data-table td {
            padding: 8px;
            border: 1px solid #e5e7eb;
        }

        table.data-table tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .badge-pending {
            background: #FEF3C7;
            color: #92400E;
            padding: 4px 8px;
            font-weight: bold;
        }

        .badge-verified {
            background: #D1FAE5;
            color: #065F46;
            padding: 4px 8px;
            font-weight: bold;
        }

        .badge-rejected {
            background: #FEE2E2;
            color: #991B1B;
            padding: 4px 8px;
            font-weight: bold;
        }

        .total-section {
            margin-top: 15px;
        }

        .total-table {
            width: 300px;
            float: right;
        }

        .total-table td {
            border: 1px solid #e5e7eb;
            padding: 8px;
        }

        .grand-total {
            background: #059669;
            color: white;
            font-weight: bold;
        }

        .footer {
            position: fixed;
            bottom: 15px;
            left: 25px;
            right: 25px;
            border-top: 1px solid #d1d5db;
            padding-top: 8px;
            color: #6b7280;
            font-size: 10px;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <div class="header">

        <table class="company-table">
            <tr>

                <td width="80">
                    <img src="{{ public_path('img/logo.png') }}" class="logo">
                </td>

                <td>
                    <div class="company-name">
                        CV. NISRINA JAYA
                    </div>

                    <div class="company-info">
                        Jl. Contoh Alamat No. 123, Surabaya, Jawa Timur <br>
                        Telp: 0812-3456-7890 | Email: info@nisrinajaya.com
                    </div>
                </td>

                <td align="right">
                    <strong>Tanggal Cetak</strong><br>
                    {{ now()->format('d/m/Y H:i') }}
                </td>

            </tr>
        </table>

    </div>

    {{-- JUDUL --}}
    <div class="report-title">
        <h2>LAPORAN DATA PEMBAYARAN</h2>
        <p>Riwayat Pembayaran DP dan Pelunasan Customer</p>
    </div>

    <div style="margin-bottom:20px;border-left:4px solid #059669;background:#f0fdf4;padding:10px;">

        <strong>Periode :</strong>

        @if (request('tanggal_dari') && request('tanggal_sampai'))
            {{ \Carbon\Carbon::parse(request('tanggal_dari'))->format('d/m/Y') }}
            -
            {{ \Carbon\Carbon::parse(request('tanggal_sampai'))->format('d/m/Y') }}
        @else
            Semua Data
        @endif

    </div>

    {{-- SUMMARY --}}
    <div class="summary">

        <table class="summary-table">

            <tr>

                <td>
                    <div class="summary-label">
                        TOTAL PEMBAYARAN
                    </div>

                    <div class="summary-value">
                        {{ $payments->count() }}
                    </div>
                </td>

                <td>
                    <div class="summary-label">
                        PENDING
                    </div>

                    <div class="summary-value">
                        {{ $payments->where('status', 'pending')->count() }}
                    </div>
                </td>

                <td>
                    <div class="summary-label">
                        VERIFIED
                    </div>

                    <div class="summary-value">
                        {{ $payments->where('status', 'verified')->count() }}
                    </div>
                </td>

                <td>
                    <div class="summary-label">
                        REJECTED
                    </div>

                    <div class="summary-value">
                        {{ $payments->where('status', 'rejected')->count() }}
                    </div>
                </td>

                <td>
                    <div class="summary-label">
                        TOTAL NOMINAL
                    </div>

                    <div class="summary-value">
                        Rp {{ number_format($payments->sum('amount'), 0, ',', '.') }}
                    </div>
                </td>

            </tr>

        </table>

    </div>

    {{-- TABEL --}}
    <table class="data-table">

        <thead>

            <tr>

                <th width="40">No</th>

                <th>Invoice</th>

                <th>Customer</th>

                <th>Jenis</th>

                <th>Metode</th>

                <th class="text-right">
                    Nominal
                </th>

                <th>Status</th>

                <th>Tanggal</th>

            </tr>

        </thead>

        <tbody>

            @foreach ($payments as $payment)
                <tr>

                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $payment->invoice->nomor_invoice }}
                    </td>

                    <td>
                        {{ $payment->invoice->serviceOrder->customer->nama }}
                    </td>

                    <td>
                        {{ strtoupper($payment->payment_type) }}
                    </td>

                    <td>
                        {{ ucfirst($payment->payment_method) }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                    </td>

                    <td class="text-center">

                        @if ($payment->status == 'verified')
                            <span class="badge-verified">
                                VERIFIED
                            </span>
                        @elseif($payment->status == 'pending')
                            <span class="badge-pending">
                                PENDING
                            </span>
                        @else
                            <span class="badge-rejected">
                                REJECTED
                            </span>
                        @endif

                    </td>

                    <td>
                        {{ $payment->created_at->format('d/m/Y') }}
                    </td>

                </tr>
            @endforeach

        </tbody>

    </table>

    {{-- TOTAL --}}
    <div class="total-section">

        <table class="total-table">

            <tr class="grand-total">

                <td>
                    Total Nominal Pembayaran
                </td>

                <td align="right">

                    Rp {{ number_format($payments->sum('amount'), 0, ',', '.') }}

                </td>

            </tr>

        </table>

    </div>

    {{-- FOOTER --}}
    <div class="footer">
        Dokumen ini dibuat secara otomatis oleh Sistem Manajemen Servis
        CV. NISRINA JAYA.
    </div>

</body>

</html>
