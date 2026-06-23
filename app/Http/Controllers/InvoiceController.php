<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('admin.invoices.index');
    }

    public function data(Request $request)
    {
        $query = Invoice::with([
            'serviceOrder.customer'
        ])->latest();

        if ($request->filled('tanggal_dari')) {

            $query->whereDate(
                'tanggal_invoice',
                '>=',
                $request->tanggal_dari
            );
        }

        if ($request->filled('tanggal_sampai')) {

            $query->whereDate(
                'tanggal_invoice',
                '<=',
                $request->tanggal_sampai
            );
        }


        return DataTables::of($query)

            ->addIndexColumn()

            ->addColumn('customer', function ($row) {
                return $row->serviceOrder->customer->nama ?? '-';
            })

            ->editColumn('tanggal_invoice', function ($row) {
                return $row->tanggal_invoice
                    ? \Carbon\Carbon::parse(
                        $row->tanggal_invoice
                    )->format('d/m/Y')
                    : '-';
            })

            ->addColumn('total_rupiah', function ($row) {
                return 'Rp ' .
                    number_format(
                        $row->total,
                        0,
                        ',',
                        '.'
                    );
            })

            ->addColumn('status_badge', function ($row) {

                if ($row->status == 'lunas') {

                    return '
                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                    Lunas
                </span>';
                }

                return '
            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                Belum Bayar
            </span>';
            })

            ->addColumn('aksi', function ($row) {

                $buttons = '
    <div class="flex items-center justify-center gap-2">

        <a href="' . route('admin.invoices.show', $row->id) . '"
            class="inline-flex items-center px-3 py-2 rounded-lg bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium transition">

            Detail
        </a>
    ';

                // tombol lunas / upload bukti
                if ($row->status == 'belum_bayar') {

                    $buttons .= '
        <button
            type="button"
            data-id="' . $row->id . '"
            class="btn-lunas px-3 py-2 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-medium transition">

            Lunas
        </button>
        ';
                }

                // kalau sudah lunas (opsional: tampilkan badge)
                if ($row->status == 'lunas') {

                    $buttons .= '
        <span class="px-3 py-2 rounded-lg bg-green-100 text-green-700 text-xs font-semibold">
            Sudah Lunas
        </span>
        ';
                }

                $buttons .= '</div>';

                return $buttons;
            })

            ->rawColumns([
                'status_badge',
                'aksi'
            ])

            ->make(true);
    }

    public function show(Invoice $invoice)
    {
        $invoice->load([
            'serviceOrder.customer',
            'serviceOrder.technician',
        ]);

        return view('admin.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        return view('admin.invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'diskon' => 'nullable|numeric|min:0',
        ]);

        $diskon = $request->diskon ?? 0;

        $invoice->update([
            'diskon' => $diskon,
            'total'  => $invoice->subtotal - $diskon,
        ]);

        return redirect()
            ->route('admin.invoices.index')
            ->with('success', 'Invoice berhasil diperbarui');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()
            ->route('admin.invoices.index')
            ->with('success', 'Invoice berhasil dihapus');
    }

    public function markAsPaid(Invoice $invoice)
    {
        $invoice->update([
            'status' => 'lunas'
        ]);

        return back()->with(
            'success',
            'Invoice berhasil dilunasi'
        );
    }

    public function markAsPaidWithProof(Request $request, Invoice $invoice)
    {
        // dd(
        //     $request->all(),
        //     $request->hasFile('bukti_bayar'),
        //     $request->file('bukti_bayar')
        // );
        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // upload file
        $file = $request->file('bukti_bayar');
        $path = $file->store('bukti-bayar', 'public');

        // update invoice
        $invoice->update([
            'status' => 'lunas',
            'bukti_bayar' => $path,
        ]);

        return redirect()
            ->route('admin.invoices.index')
            ->with('success', 'Invoice berhasil dilunasi dan bukti pembayaran tersimpan');
    }

    public function export(Invoice $invoice)
    {
        $invoice->load([
            'serviceOrder.customer',
            'serviceOrder.technician',
            'serviceOrder.details.service'
        ]);

        $pdf = Pdf::loadView('admin.invoices.export', compact('invoice'));

        return $pdf->stream('invoice-' . $invoice->nomor_invoice . '.pdf');
    }

    public function exportPdf(Request $request)
    {
        $query = Invoice::with([
            'serviceOrder.customer'
        ])->latest();

        if ($request->filled('tanggal_dari')) {

            $query->whereDate(
                'tanggal_invoice',
                '>=',
                $request->tanggal_dari
            );
        }

        if ($request->filled('tanggal_sampai')) {

            $query->whereDate(
                'tanggal_invoice',
                '<=',
                $request->tanggal_sampai
            );
        }

        $invoices = $query->get();

        $pdf = Pdf::loadView(
            'admin.invoices.export-all',
            compact('invoices')
        );

        return $pdf->stream(
            'laporan-invoice-' . now()->format('YmdHis') . '.pdf'
        );
    }
}
