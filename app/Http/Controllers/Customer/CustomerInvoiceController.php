<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class CustomerInvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::whereHas('serviceOrder.customer', function ($q) {
            $q->where('user_id', Auth::id());
        })
            ->latest()
            ->paginate(10); // ✅ langsung paginate, tanpa get()

        return view('customer.invoices.index', compact('invoices'));
    }

    public function show($id)
    {
        $invoice = Invoice::with([
            'serviceOrder.customer',
            'serviceOrder.details.service',
            'serviceOrder.details.acUnit.brand',
            'serviceOrder.details.acUnit.type',
            'serviceOrder.details.acUnit.capacity',
            'payments',
        ])
            ->where('id', $id)
            ->whereHas('serviceOrder.customer', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->firstOrFail();

        $totalPaid = $invoice->payments
            ->where('status', 'verified')
            ->sum('amount');

        return view(
            'customer.invoices.show',
            compact(
                'invoice',
                'totalPaid'
            )
        );
    }

    public function print($id)
    {
        $invoice = Invoice::where('id', $id)
            ->whereHas('serviceOrder.customer', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->firstOrFail();

        return view('customer.invoices.print', compact('invoice'));
    }
}
