<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;

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
            'serviceOrder'
        ])
            ->where('id', $id)
            ->whereHas('serviceOrder.customer', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->firstOrFail();

        return view('customer.invoices.show', compact('invoice'));
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
