<?php

namespace App\Http\Controllers;

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
        $query = Payment::with([
            'invoice.serviceOrder.customer'
        ]);

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

            ->addColumn('invoice_number', fn($row)
            => $row->invoice->nomor_invoice)

            ->addColumn('customer', fn($row)
            => $row->invoice->serviceOrder->customer->nama)

            ->addColumn('amount_rupiah', fn($row)
            => 'Rp ' . number_format($row->amount, 0, ',', '.'))

            ->addColumn('proof_button', function ($row) {

                if (!$row->proof_file) {
                    return '-';
                }

                return '
            <a href="' . asset('storage/' . $row->proof_file) . '"
               target="_blank"
               class="px-3 py-1 bg-blue-500 text-white rounded">
               Lihat Bukti
            </a>
        ';
            })

            ->addColumn('status_badge', function ($row) {

                return match ($row->status) {

                    'pending' =>
                    '<span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">
                Pending
            </span>',

                    'verified' =>
                    '<span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                Verified
            </span>',

                    'rejected' =>
                    '<span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">
                Rejected
            </span>',

                    default => '-',
                };
            })

            ->addColumn('aksi', function ($row) {

                if ($row->status === 'pending') {

                    return '
                <a href="' . route('admin.payments.show', $row->id) . '"
                   class="px-3 py-1 bg-indigo-600 text-white rounded">
                    Detail
                </a>
            ';
                }

                return '
                    <a href="' . route('admin.payments.show', $row->id) . '"
                    class="btn-detail">
                    Detail
                    </a>';
            })

            ->rawColumns([
                'proof_button',
                'status_badge',
                'aksi'
            ])

            ->make(true);
    }

    public function export($id)
    {
        $payment = Payment::with([
            'invoice.serviceOrder.customer',
            'invoice.serviceOrder.details.service'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('admin.payments.export', compact('payment'));

        return $pdf->stream('Pembayaran-' . $payment->invoice->nomor_invoice . '.pdf');
    }

    public function exportPdf(Request $request)
    {
        $query = Payment::with([
            'invoice.serviceOrder.customer'
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
            'invoice.serviceOrder.customer'
        ])->findOrFail($id);

        return view(
            'admin.payments.show',
            compact('payment')
        );
    }

    public function reject(Payment $payment)
    {
        $payment->update([
            'status' => 'rejected'
        ]);

        return back()->with(
            'success',
            'Pembayaran berhasil ditolak.'
        );
    }

    public function verify(Payment $payment)
    {
        $payment->update([
            'status' => 'verified'
        ]);

        $invoice = $payment->invoice;

        $totalPaid = $invoice->payments()
            ->where('status', 'verified')
            ->sum('amount');

        if ($totalPaid >= $invoice->total) {

            $invoice->update([
                'status' => 'lunas'
            ]);
        } else {

            $invoice->update([
                'status' => 'bayar_sebagian'
            ]);
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
