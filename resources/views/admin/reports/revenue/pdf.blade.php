<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Pendapatan</title>

    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #111827;
            margin: 0;
            padding: 0;
            background: #ffffff;
        }

        /* HEADER */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 32px;
            border-bottom: 2px solid #10b981;
        }

        .logo img {
            width: 70px;
        }

        .company-name {
            font-size: 16px;
            font-weight: bold;
        }

        .company-info {
            font-size: 11px;
            color: #6b7280;
            margin-top: 4px;
            line-height: 1.4;
        }

        /* TITLE */
        .title {
            padding: 20px 32px 10px 32px;
        }

        .title h2 {
            margin: 0;
            font-size: 18px;
        }

        .title p {
            margin: 4px 0 0 0;
            font-size: 11px;
            color: #6b7280;
        }

        /* TABLE */
        .table-container {
            padding: 0 32px 32px 32px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #ecfdf5;
        }

        th {
            text-align: left;
            font-size: 11px;
            padding: 10px;
            color: #065f46;
            text-transform: uppercase;
            border-bottom: 1px solid #d1fae5;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 11px;
        }

        tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        .text-right {
            text-align: right;
        }

        /* FOOTER */
        .footer {
            padding: 20px 32px;
            font-size: 10px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            text-align: center;
        }

        /* TOTAL ROW */
        .total-row {
            font-weight: bold;
            background: #f0fdf4;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <div class="header">

        <div style="display:flex; gap:12px; align-items:center;">

            <div class="logo">
                <img src="{{ public_path('img/logo.png') }}">
            </div>

            <div>
                <div class="company-name">
                    CV. NISRINA JAYA
                </div>

                <div class="company-info">
                    Jl. Contoh Alamat No. 123, Surabaya, Jawa Timur <br>
                    Telp: 0812-3456-7890
                </div>
            </div>

        </div>

        <div style="text-align:right;">
            <div style="font-size:12px; font-weight:bold; color:#10b981;">
                LAPORAN PENDAPATAN
            </div>

            <div style="font-size:10px; color:#6b7280;">
                Financial Report
            </div>

            {{-- PERIODE --}}
            <div style="margin-top:6px; font-size:10px; font-weight:bold;">
                Periode:
            </div>

            <div style="font-size:10px; color:#6b7280;">
                {{ $start ? \Carbon\Carbon::parse($start)->format('d M Y') : 'Awal' }}
                s/d
                {{ $end ? \Carbon\Carbon::parse($end)->format('d M Y') : 'Akhir' }}
            </div>
        </div>

    </div>

    {{-- TITLE --}}
    <div class="title">
        <h2>Ringkasan Pendapatan</h2>
        <p>Rekap transaksi pemasukan perusahaan</p>
    </div>

    {{-- TABLE --}}
    <div class="table-container">

        <table>

            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Customer</th>
                    <th>Invoice</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>

            <tbody>

                @php
                    $grandTotal = 0;
                @endphp

                @foreach ($data as $row)

                    @php
                        $grandTotal += $row->grand_total;
                    @endphp

                    <tr>
                        <td>
                            {{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}
                        </td>

                        <td>
                            {{ $row->customer->nama ?? '-' }}
                        </td>

                        <td>
                            {{ $row->invoice->nomor_invoice ?? ('INV-' . $row->id) }}
                        </td>

                        <td class="text-right">
                            Rp {{ number_format($row->grand_total, 0, ',', '.') }}
                        </td>
                    </tr>

                @endforeach

                {{-- TOTAL --}}
                <tr class="total-row">
                    <td colspan="3" class="text-right">TOTAL PENDAPATAN</td>
                    <td class="text-right">
                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

    {{-- FOOTER --}}
    <div class="footer">
        © {{ date('Y') }} CV. NISRINA JAYA — Confidential Financial Report
    </div>

</body>

</html>
