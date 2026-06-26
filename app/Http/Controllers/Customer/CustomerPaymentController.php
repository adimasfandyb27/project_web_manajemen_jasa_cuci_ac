<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class CustomerPaymentController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'invoice_id'     => 'required|exists:invoices,id',
            'payment_type'   => 'required|in:dp,pelunasan',
            'payment_method' => 'required|in:cash,transfer',
            'proof_file'     => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $invoice = Invoice::with([
            'serviceOrder.customer',
            'payments'
        ])->findOrFail($request->invoice_id);

        // Pastikan invoice milik customer yang login
        if (
            $invoice->serviceOrder->customer->user_id
            !== auth()->id()
        ) {
            abort(403);
        }

        // Cek apakah masih ada pembayaran pending
        $hasPendingPayment = $invoice->payments()
            ->where('status', 'pending')
            ->exists();

        if ($hasPendingPayment) {
            return back()->with(
                'error',
                'Masih ada pembayaran yang menunggu verifikasi admin.'
            );
        }

        // Hitung total pembayaran yang sudah diverifikasi
        $totalPaid = $invoice->payments()
            ->where('status', 'verified')
            ->sum('amount');

        // Tentukan nominal otomatis
        if ($request->payment_type === 'dp') {

            // DP = 50%
            $amount = $invoice->total * 0.5;

            // Jangan boleh DP dua kali
            $hasDp = $invoice->payments()
                ->where('payment_type', 'dp')
                ->where('status', 'verified')
                ->exists();

            if ($hasDp) {
                return back()->with(
                    'error',
                    'DP sudah pernah dibayarkan.'
                );
            }
        } else {

            // Pelunasan = sisa tagihan
            $amount = $invoice->total - $totalPaid;

            if ($amount <= 0) {
                return back()->with(
                    'error',
                    'Invoice sudah lunas.'
                );
            }
        }

        $proofFile = $request
            ->file('proof_file')
            ->store('payments', 'public');

        Payment::create([
            'invoice_id'     => $invoice->id,
            'amount'         => $amount,
            'payment_type'   => $request->payment_type,
            'payment_method' => $request->payment_method,
            'proof_file'     => $proofFile,
            'status'         => 'pending',
            'paid_at'        => now(),
        ]);


        return redirect()
            ->route(
                'customer.invoices.show',
                $invoice->id
            )
            ->with(
                'success',
                'Pembayaran berhasil dikirim dan sedang menunggu verifikasi admin.'
            );
    }

    public function history($invoiceId)
    {
        $invoice = Invoice::with([
            'payments'
        ])->findOrFail($invoiceId);

        if (
            $invoice->serviceOrder->customer->user_id
            !== auth()->id()
        ) {
            abort(403);
        }

        return view(
            'customer.payments.history',
            compact('invoice')
        );
    }
}
