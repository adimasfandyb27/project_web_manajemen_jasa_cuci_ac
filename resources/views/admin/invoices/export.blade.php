<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->nomor_invoice }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #374151;
            background: #fff;
        }

        .container {
            padding: 25px;
        }

        /* HEADER */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #10b981;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .company {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .logo img {
            width: 65px;
            height: 65px;
            object-fit: contain;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #10b981;
            letter-spacing: 0.5px;
        }

        .company-info {
            font-size: 11px;
            color: #6b7280;
            margin-top: 2px;
            line-height: 1.4;
        }

        /* INVOICE BOX */
        .invoice-box {
            text-align: right;
        }

        .invoice-title {
            font-size: 20px;
            font-weight: bold;
            color: #111827;
            letter-spacing: 1px;
        }

        .invoice-number {
            margin-top: 3px;
            font-weight: 600;
            color: #374151;
        }

        .invoice-date {
            margin-top: 3px;
            font-size: 11px;
            color: #6b7280;
        }

        .status {
            display: inline-block;
            margin-top: 8px;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: bold;
        }

        .paid {
            background: #d1fae5;
            color: #065f46;
        }

        .unpaid {
            background: #fef3c7;
            color: #92400e;
        }

        /* SECTION */
        .section {
            margin-bottom: 18px;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 6px;
            border-left: 3px solid #10b981;
            padding-left: 6px;
        }

        .text-muted {
            color: #6b7280;
        }

        /* TABLE */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            overflow: hidden;
        }

        .table th {
            background: #10b981;
            color: #fff;
            padding: 10px;
            font-size: 11px;
            text-align: left;
        }

        .table td {
            border-bottom: 1px solid #e5e7eb;
            padding: 10px;
            font-size: 11px;
        }

        .table tr:nth-child(even) {
            background: #f9fafb;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* TOTAL BOX */
        .total-box {
            margin-top: 18px;
            width: 300px;
            margin-left: auto;
            background: #f9fafb;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .total-final {
            font-size: 14px;
            font-weight: bold;
            color: #10b981;
            border-top: 1px solid #d1d5db;
            padding-top: 8px;
            margin-top: 8px;
        }

        /* TTD */
        .ttd {
            margin-top: 60px;
            text-align: right;
        }

        .ttd-box {
            width: 220px;
            margin-left: auto;
            text-align: center;
        }

        .ttd-name {
            margin-top: 55px;
            font-weight: bold;
            text-decoration: underline;
        }

        .ttd-title {
            font-size: 11px;
            color: #6b7280;
        }

        /* FOOTER */
        .footer {
            margin-top: 40px;
            font-size: 10px;
            text-align: center;
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

            <div class="company">

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

            <div class="invoice-box">

                <div class="invoice-title">INVOICE</div>

                <div class="invoice-number">
                    {{ $invoice->nomor_invoice }}
                </div>

                <div class="invoice-date">
                    {{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->format('d F Y') }}
                </div>

                @if ($invoice->status == 'lunas')
                    <span class="status paid">LUNAS</span>
                @else
                    <span class="status unpaid">BELUM BAYAR</span>
                @endif

            </div>

        </div>

        {{-- CUSTOMER --}}
        <div class="section">

            <div class="section-title">DATA CUSTOMER</div>

            <div class="text-muted">
                {{ $invoice->serviceOrder->customer->nama }} <br>
                {{ $invoice->serviceOrder->customer->telepon }}
            </div>

        </div>

        {{-- DETAIL --}}
        <div class="section">

            <div class="section-title">DETAIL LAYANAN</div>

            <table class="table">

                <thead>
                    <tr>
                        <th>Layanan</th>
                        <th>Unit AC</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($invoice->serviceOrder->details as $detail)
                        <tr>
                            <td>{{ $detail->service->nama_layanan }}</td>
                            <td>
                                @if ($detail->acUnit)
                                    {{ $detail->acUnit->brand->nama ?? '-' }}
                                    - {{ $detail->acUnit->type->nama ?? '-' }}
                                    ({{ $detail->acUnit->capacity->label ?? '-' }})
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">{{ $detail->qty }}</td>
                            <td class="text-right">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td class="text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

        {{-- TOTAL --}}
        <div class="total-box">

            <div class="total-row">
                <span>Subtotal Jasa</span>
                <span>Rp {{ number_format($invoice->serviceOrder->subtotal_jasa, 0, ',', '.') }}</span>
            </div>

            <div class="total-row">
                <span>Sparepart</span>
                <span>Rp {{ number_format($invoice->serviceOrder->subtotal_sparepart, 0, ',', '.') }}</span>
            </div>

            <div class="total-row">
                <span>Diskon</span>
                <span>Rp {{ number_format($invoice->serviceOrder->diskon, 0, ',', '.') }}</span>
            </div>

            <div class="total-final">
                TOTAL: Rp {{ number_format($invoice->total, 0, ',', '.') }}
            </div>

        </div>

        {{-- TTD --}}
        <div class="ttd">

            <div class="ttd-box">

                <div>Mengetahui,</div>

                <div class="ttd-name">
                    H. Ahmad Sulaiman
                </div>

                <div class="ttd-title">
                    Pimpinan CV. NISRINA JAYA
                </div>

            </div>

        </div>

        {{-- FOOTER --}}
        <div class="footer">
            Invoice ini sah tanpa tanda tangan digital. Terima kasih atas kepercayaan Anda.
        </div>

    </div>

</body>

</html>
