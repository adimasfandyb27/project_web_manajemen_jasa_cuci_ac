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
            width: 25%;
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

        .badge-success {
            background: #d1fae5;
            color: #065f46;
            padding: 4px 8px;
            border-radius: 3px;
            font-weight: bold;
        }

        .badge-process {
            background: #fef3c7;
            color: #92400e;
            padding: 4px 8px;
            border-radius: 3px;
            font-weight: bold;
        }

        .total-section {
            margin-top: 15px;
        }

        .total-table {
            width: 320px;
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
                    @if (file_exists(public_path('img/logo.png')))
                        <img src="{{ public_path('img/logo.png') }}" class="logo">
                    @endif
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

        <h2>LAPORAN DATA SERVICE ORDER</h2>

        <p>
            Ringkasan Order Servis Pelanggan
        </p>

    </div>

    {{-- SUMMARY --}}
    <div class="summary">

        <table class="summary-table">

            <tr>

                <td>

                    <div class="summary-label">
                        TOTAL ORDER
                    </div>

                    <div class="summary-value">
                        {{ $orders->count() }}
                    </div>

                </td>

                <td>

                    <div class="summary-label">
                        PROSES
                    </div>

                    <div class="summary-value">
                        {{ $orders->where('status', 'proses')->count() }}
                    </div>

                </td>

                <td>

                    <div class="summary-label">
                        SELESAI
                    </div>

                    <div class="summary-value">
                        {{ $orders->where('status', 'selesai')->count() }}
                    </div>

                </td>

                <td>

                    <div class="summary-label">
                        TOTAL NILAI SERVIS
                    </div>

                    <div class="summary-value">
                        Rp {{ number_format($orders->sum('grand_total'), 0, ',', '.') }}
                    </div>

                </td>

            </tr>

        </table>

    </div>

    {{-- TABEL DATA --}}
    <table class="data-table">

        <thead>

            <tr>

                <th width="40">No</th>
                <th>No Order</th>
                <th>Customer</th>
                <th>Teknisi</th>
                <th>Tanggal Order</th>
                <th>Total</th>
                <th>Status</th>

            </tr>

        </thead>

        <tbody>

            @forelse ($orders as $order)
                <tr>

                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $order->nomor_order }}
                    </td>

                    <td>
                        {{ $order->customer->nama ?? '-' }}
                    </td>

                    <td>
                        {{ $order->technician->nama ?? '-' }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($order->tanggal_order)->format('d/m/Y') }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                    </td>

                    <td class="text-center">

                        @if ($order->status == 'selesai')
                            <span class="badge-success">
                                SELESAI
                            </span>
                        @else
                            <span class="badge-process">
                                PROSES
                            </span>
                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7" class="text-center">
                        Tidak ada data service order
                    </td>

                </tr>
            @endforelse

        </tbody>

    </table>

    {{-- TOTAL --}}
    <div class="total-section">

        <table class="total-table">

            <tr class="grand-total">

                <td>
                    Total Keseluruhan
                </td>

                <td align="right">
                    Rp {{ number_format($orders->sum('grand_total'), 0, ',', '.') }}
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
