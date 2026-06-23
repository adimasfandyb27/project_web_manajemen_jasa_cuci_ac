<!DOCTYPE html>
<html>

<head>
    <title>Print Invoice</title>
</head>

<body onload="window.print()">

    <h2>Invoice {{ $invoice->invoice_number }}</h2>

    <p>Total: Rp {{ number_format($invoice->total, 0, ',', '.') }}</p>

</body>

</html>
