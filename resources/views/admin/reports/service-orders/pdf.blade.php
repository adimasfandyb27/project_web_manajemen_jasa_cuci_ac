<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Servis</title>

    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #111827;
            margin: 0;
            padding: 0;
            background: #ffffff;
        }

        /* ===== HEADER COMPANY ===== */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 32px;
            border-bottom: 2px solid #10b981;
        }

        .logo img {
            width: 70px;
            height: auto;
        }

        .company-name {
            font-size: 16px;
            font-weight: bold;
            color: #111827;
        }

        .company-info {
            font-size: 11px;
            color: #6b7280;
            margin-top: 4px;
            line-height: 1.4;
        }

        /* ===== TITLE ===== */
        .title {
            padding: 20px 32px 10px 32px;
        }

        .title h2 {
            margin: 0;
            font-size: 18px;
            color: #111827;
        }

        .title p {
            margin: 4px 0 0 0;
            font-size: 11px;
            color: #6b7280;
        }

        /* ===== TABLE ===== */
        .table-container {
            padding: 0 32px 32px 32px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }

        thead {
            background: #ecfdf5;
        }

        th {
            text-align: left;
            font-size: 11px;
            padding: 10px;
            color: #065f46;
            border-bottom: 1px solid #d1fae5;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 11px;
        }

        tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        tbody tr:hover {
            background: #f0fdf4;
        }

        .text-right {
            text-align: right;
        }

        /* ===== STATUS BADGE ===== */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 10px;
            border-radius: 999px;
            font-weight: bold;
        }

        .done {
            background: #dcfce7;
            color: #166534;
        }

        .pending {
            background: #fef9c3;
            color: #854d0e;
        }

        /* ===== FOOTER ===== */
        .footer {
            padding: 20px 32px;
            font-size: 10px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            text-align: center;
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
                LAPORAN SERVIS
            </div>

            <div style="font-size:10px; color:#6b7280;">
                Generated Report
            </div>

            {{-- PERIODE --}}
            <div style="margin-top:6px; font-size:10px; color:#111827; font-weight:bold;">
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
        <h2>Ringkasan Data Servis</h2>
        <p>Periode laporan transaksi servis pelanggan</p>
    </div>

    {{-- TABLE --}}
    <div class="table-container">

        <table>

            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Customer</th>
                    <th>Teknisi</th>
                    <th>Status</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($data as $row)
                    <tr>

                        <td>
                            {{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}
                        </td>

                        <td>
                            {{ $row->customer->nama ?? '-' }}
                        </td>

                        <td>
                            {{ $row->technician->nama ?? '-' }}
                        </td>

                        <td>
                            @if ($row->status == 'done')
                                <span class="badge done">SELESAI</span>
                            @else
                                <span class="badge pending">
                                    {{ strtoupper($row->status) }}
                                </span>
                            @endif
                        </td>

                        <td class="text-right">
                            Rp {{ number_format($row->grand_total, 0, ',', '.') }}
                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>

    </div>

    {{-- FOOTER --}}
    <div class="footer">
        © {{ date('Y') }} CV. NISRINA JAYA — Confidential Service Report
    </div>

</body>

</html>
