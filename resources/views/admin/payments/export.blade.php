<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Detail Pembayaran</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #374151;
            margin: 0;
            background: #ffffff;
        }

        .container {
            padding: 30px;
        }

        /* HEADER */

        .header {
            border-bottom: 4px solid #10b981;
            padding-bottom: 18px;
            margin-bottom: 25px;
        }

        .company-table {
            width: 100%;
        }

        .company-table td {
            vertical-align: top;
        }

        .logo {
            width: 70px;
        }

        .logo img {
            width: 60px;
        }

        .company-name {
            font-size: 22px;
            font-weight: bold;
            color: #059669;
        }

        .company-info {
            color: #6b7280;
            font-size: 11px;
            line-height: 1.5;
        }

        .title {
            text-align: right;
        }

        .title h2 {
            margin: 0;
            color: #111827;
            font-size: 22px;
        }

        .title p {
            margin-top: 5px;
            color: #6b7280;
            font-size: 11px;
        }

        /* SECTION */

        .section-title {
            background: #ecfdf5;
            color: #065f46;
            padding: 10px 14px;
            font-size: 13px;
            font-weight: bold;
            border-left: 5px solid #10b981;
            margin-top: 20px;
            margin-bottom: 12px;
        }

        /* SUMMARY */

        .summary {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px;
        }

        .summary td {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px;
            width: 33%;
        }

        .label {
            color: #6b7280;
            font-size: 10px;
        }

        .value {
            margin-top: 6px;
            font-weight: bold;
            font-size: 14px;
            color: #111827;
        }

        .amount {
            color: #059669;
            font-size: 18px;
        }

        /* DETAIL */

        .detail-table {
            width: 100%;
            border-collapse: collapse;
        }

        .detail-table td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-table td:first-child {
            width: 220px;
            color: #6b7280;
        }

        /* STATUS */

        .badge {
            display: inline-block;
            padding: 5px 12px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 20px;
        }

        .pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .verified {
            background: #D1FAE5;
            color: #065F46;
        }

        .rejected {
            background: #FEE2E2;
            color: #991B1B;
        }

        /* IMAGE */

        .proof {
            text-align: center;
            margin-top: 10px;
        }

        .proof img {
            width: 220px;
            height: auto;
            max-height: 280px;
            object-fit: contain;
            border: 1px solid #d1d5db;
            padding: 5px;
            border-radius: 6px;
            background: #fff;
        }

        /* SIGN */

        .sign {
            margin-top: 70px;
            width: 240px;
            float: right;
            text-align: center;
        }

        .sign-name {
            margin-top: 60px;
            font-weight: bold;
            text-decoration: underline;
        }

        /* FOOTER */

        .footer {
            clear: both;
            margin-top: 100px;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
    </style>

</head>

<body>

    <div class="container">

        {{-- HEADER --}}
        <div class="header">

            <table class="company-table">

                <tr>

                    <td>

                        <table>

                            <tr>

                                <td class="logo">
                                    <img src="{{ public_path('img/logo.png') }}">
                                </td>

                                <td>

                                    <div class="company-name">
                                        CV. NISRINA JAYA
                                    </div>

                                    <div class="company-info">
                                        Jl. Contoh Alamat No.123 <br>
                                        Surabaya, Jawa Timur <br>
                                        Telp : 0812-3456-7890
                                    </div>

                                </td>

                            </tr>

                        </table>

                    </td>

                    <td class="title">

                        <h2>DETAIL PEMBAYARAN</h2>

                        <p>
                            {{ now()->format('d F Y') }}
                        </p>

                    </td>

                </tr>

            </table>

        </div>

        {{-- SUMMARY --}}
        <div class="section-title">
            Informasi Pembayaran
        </div>

        <table class="summary">

            <tr>

                <td>

                    <div class="label">Invoice</div>

                    <div class="value">
                        {{ $payment->invoice->nomor_invoice }}
                    </div>

                </td>

                <td>

                    <div class="label">Customer</div>

                    <div class="value">
                        {{ $payment->invoice->serviceOrder->customer->nama }}
                    </div>

                </td>

                <td>

                    <div class="label">Nominal</div>

                    <div class="value amount">
                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                    </div>

                </td>

            </tr>

        </table>

        {{-- DETAIL --}}
        <div class="section-title">
            Detail Transaksi
        </div>

        <table class="detail-table">

            <tr>
                <td>Jenis Pembayaran</td>
                <td>{{ strtoupper($payment->payment_type) }}</td>
            </tr>

            <tr>
                <td>Metode Pembayaran</td>
                <td>{{ ucfirst($payment->payment_method) }}</td>
            </tr>

            <tr>

                <td>Status</td>

                <td>

                    @if ($payment->status == 'pending')
                        <span class="badge pending">PENDING</span>
                    @elseif($payment->status == 'verified')
                        <span class="badge verified">VERIFIED</span>
                    @else
                        <span class="badge rejected">REJECTED</span>
                    @endif

                </td>

            </tr>

            <tr>

                <td>Tanggal Pembayaran</td>

                <td>
                    {{ \Carbon\Carbon::parse($payment->created_at)->format('d F Y H:i') }}
                </td>

            </tr>

        </table>

        {{-- BUKTI --}}
        <div class="section-title">
            Bukti Transfer
        </div>

        <div class="proof">

            @if ($payment->proof_file)
                <img src="{{ public_path('storage/' . $payment->proof_file) }}" alt="Bukti Transfer">
            @else
                <p>Tidak ada bukti transfer.</p>
            @endif

        </div>

        {{-- TTD --}}
        {{-- <div class="sign">

            Mengetahui,

            <div class="sign-name">
                H. Ahmad Sulaiman
            </div>

            Pimpinan CV. NISRINA JAYA

        </div> --}}

        {{-- FOOTER --}}
        <div class="footer">

            Dokumen ini dibuat secara otomatis oleh Sistem Informasi Jasa Servis AC CV. NISRINA JAYA.

        </div>

    </div>

</body>

</html>
