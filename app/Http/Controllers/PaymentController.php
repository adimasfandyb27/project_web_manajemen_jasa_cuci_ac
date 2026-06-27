<?php

namespace App\Http\Controllers;

use App\Models\CustomerNotification;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.payments.index', [

            'totalPayment' => Payment::count(),

            'totalPending' => Payment::where(
                'status',
                'pending'
            )->count(),

            'totalVerified' => Payment::where(
                'status',
                'verified'
            )->count(),

        ]);
    }

    public function data(Request $request)
    {
        $query = Payment::query()
            ->join('invoices', 'payments.invoice_id', '=', 'invoices.id')
            ->join('service_orders', 'invoices.service_order_id', '=', 'service_orders.id')
            ->join('customers', 'service_orders.customer_id', '=', 'customers.id')
            ->select(
                'payments.*',
                'invoices.nomor_invoice',
                'customers.nama as customer_name'
            );

        if ($request->status) {
            $query->where(
                'status',
                $request->status
            );
        }

        if ($request->tanggal_dari) {
            $query->whereDate(
                'paid_at',
                '>=',
                $request->tanggal_dari
            );
        }

        if ($request->tanggal_sampai) {
            $query->whereDate(
                'paid_at',
                '<=',
                $request->tanggal_sampai
            );
        }

        return DataTables::of($query)

            ->addIndexColumn()

            ->editColumn('invoice_number', function ($row) {
                return $row->nomor_invoice;
            })

            ->editColumn('customer', function ($row) {
                return $row->customer_name;
            })

            ->addColumn('amount_rupiah', fn ($row) => 'Rp '.number_format($row->amount, 0, ',', '.'))

            ->addColumn('proof_button', function ($row) {

                if (! $row->proof_file) {
                    return '-';
                }

                return '
            <a href="'.asset('storage/'.$row->proof_file).'"
               target="_blank"
               class="px-3 py-1 bg-blue-500 text-white rounded">
               Lihat Bukti
            </a>
        ';
            })

            ->addColumn('status_badge', function ($row) {

                return match ($row->status) {

                    'pending' => '<span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">
                Pending
            </span>',

                    'verified' => '<span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                Verified
            </span>',

                    'rejected' => '<span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">
                Rejected
            </span>',

                    default => '-',
                };
            })

            ->addColumn('aksi', function ($row) {

                return '
                <a href="'.route('admin.payments.show', $row->id).'"
                   class="inline-flex items-center px-3 py-2 rounded-lg bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium transition">
                    Detail
                </a>';
            })

            ->rawColumns([
                'proof_button',
                'status_badge',
                'aksi',
            ])

            ->make(true);
    }

    public function export($id)
    {
        $payment = Payment::with([
            'invoice.serviceOrder.customer',
            'invoice.serviceOrder.details.service',
        ])->findOrFail($id);

        $pdf = Pdf::loadView('admin.payments.export', compact('payment'));

        return $pdf->stream('Pembayaran-'.$payment->invoice->nomor_invoice.'.pdf');
    }

    public function exportPdf(Request $request)
    {
        $query = Payment::with([
            'invoice.serviceOrder.customer',
        ]);

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Tanggal Dari
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('paid_at', '>=', $request->tanggal_dari);
        }

        // Filter Tanggal Sampai
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('paid_at', '<=', $request->tanggal_sampai);
        }

        $payments = $query
            ->orderByDesc('paid_at')
            ->get();

        $pdf = Pdf::loadView(
            'admin.payments.export-all',
            compact('payments')
        )->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan-Data-Pembayaran.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = Payment::with([
            'invoice.serviceOrder.customer',
        ])->findOrFail($id);

        return view(
            'admin.payments.show',
            compact('payment')
        );
    }

    public function reject(Payment $payment)
    {
        $payment->update([
            'status' => 'rejected',
        ]);

        // ==================================
        // NOTIFIKASI KE CUSTOMER
        // ==================================

        $serviceOrder = $payment->invoice->serviceOrder;
        if ($serviceOrder && $serviceOrder->customer) {
            CustomerNotification::createForCustomer(
                $serviceOrder->customer->id,
                "Pembayaran Ditolak - #{$payment->invoice->nomor_invoice}",
                "Maaf, pembayaran Anda untuk invoice {$payment->invoice->nomor_invoice} ditolak. Silakan hubungi admin untuk detail lebih lanjut.",
                'payment_rejected',
                $payment->id,
                Payment::class
            );
        }

        return back()->with(
            'success',
            'Pembayaran berhasil ditolak.'
        );
    }

    public function verify(Payment $payment)
    {
        $payment->update([
            'status' => 'verified',
        ]);

        $invoice = $payment->invoice;

        $totalPaid = $invoice->payments()
            ->where('status', 'verified')
            ->sum('amount');

        if ($totalPaid >= $invoice->total) {

            $invoice->update([
                'status' => 'lunas',
            ]);
        } else {

            $invoice->update([
                'status' => 'bayar_sebagian',
            ]);
        }

        // ==================================
        // NOTIFIKASI KE CUSTOMER
        // ==================================

        $serviceOrder = $invoice->serviceOrder;
        if ($serviceOrder && $serviceOrder->customer) {
            $isLunas = $totalPaid >= $invoice->total;
            CustomerNotification::createForCustomer(
                $serviceOrder->customer->id,
                $isLunas
                    ? "Pembayaran Lunas - #{$invoice->nomor_invoice}"
                    : "Pembayaran Diverifikasi - #{$invoice->nomor_invoice}",
                $isLunas
                    ? "Pembayaran invoice {$invoice->nomor_invoice} telah lunas. Terima kasih!"
                    : "Pembayaran DP untuk invoice {$invoice->nomor_invoice} telah diverifikasi.",
                'payment_verified',
                $payment->id,
                Payment::class
            );
        }

        return back()->with(
            'success',
            'Pembayaran berhasil diverifikasi.'
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
