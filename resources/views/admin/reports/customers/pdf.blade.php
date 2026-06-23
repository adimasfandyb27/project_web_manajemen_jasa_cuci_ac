<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Customer</title>

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

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /* BADGE */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 10px;
            border-radius: 999px;
            font-weight: bold;
        }

        .active {
            background: #dcfce7;
            color: #166534;
        }

        .inactive {
            background: #f3f4f6;
            color: #6b7280;
        }

        /* FOOTER */
        .footer {
            padding: 20px 32px;
            font-size: 10px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            text-align: center;
        }

        /* SUMMARY BOX */
        .summary {
            padding: 0 32px 20px 32px;
            font-size: 11px;
            color: #374151;
        }

        .summary strong {
            color: #111827;
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
                LAPORAN CUSTOMER
            </div>

            <div style="font-size:10px; color:#6b7280;">
                Customer Analytics Report
            </div>

            <div style="margin-top:6px; font-size:10px; font-weight:bold;">
                Generated:
            </div>

            <div style="font-size:10px; color:#6b7280;">
                Periode:
                {{ $start->format('d M Y') }}
                s/d
                {{ $end->format('d M Y') }}
            </div>
        </div>

    </div>

    {{-- TITLE --}}
    <div class="title">
        <h2>Daftar Customer & Aktivitas Servis</h2>
        <p>Ringkasan seluruh pelanggan dan jumlah transaksi servis</p>
    </div>

    {{-- SUMMARY --}}
    <div class="summary">
        Total Customer:
        <strong>{{ $data->count() }}</strong>
        |
        Customer Aktif:
        <strong>{{ $data->where('service_orders_count', '>', 0)->count() }}</strong>
    </div>

    {{-- TABLE --}}
    <div class="table-container">

        <table>

            <thead>
                <tr>
                    <th>Nama</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th class="text-center">Order</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($data as $row)
                    <tr>

                        <td>{{ $row->nama }}</td>
                        <td>{{ $row->telepon }}</td>
                        <td>{{ $row->alamat ?? '-' }}</td>

                        <td class="text-center">
                            {{ $row->service_orders_count }}
                        </td>

                        <td class="text-center">
                            @if ($row->service_orders_count > 0)
                                <span class="badge active">AKTIF</span>
                            @else
                                <span class="badge inactive">NON AKTIF</span>
                            @endif
                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>

    </div>

    {{-- FOOTER --}}
    <div class="footer">
        © {{ date('Y') }} CV. NISRINA JAYA — Customer Report System
    </div>

</body>

</html>
