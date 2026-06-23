<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LAPORAN ORDER SERVIS
    |--------------------------------------------------------------------------
    */

    public function serviceOrders(Request $request)
    {
        $query = ServiceOrder::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59',
            ]);
        }

        $totalOrder = (clone $query)->count();

        $totalItemService = ServiceOrderDetail::whereHas(
            'order',
            function ($q) use ($request) {
                if ($request->filled('start_date') && $request->filled('end_date')) {
                    $q->whereBetween('created_at', [
                        $request->start_date . ' 00:00:00',
                        $request->end_date . ' 23:59:59',
                    ]);
                }
            }
        )->count();

        $totalSelesai = (clone $query)
            ->where('status', 'selesai')
            ->count();

        return view('admin.reports.service-orders', compact(
            'totalOrder',
            'totalItemService',
            'totalSelesai'
        ));
    }

    public function serviceOrdersData(Request $request)
    {
        $query = ServiceOrder::with([
            'customer',
            'technician',
            'details.service',
        ]);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        return DataTables::of($query)

            // TANGGAL
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d/m/Y');
            })

            // CUSTOMER
            ->addColumn('customer_name', function ($row) {
                return $row->customer?->nama ?? '-';
            })

            // TEKNISI (INI YANG SEBELUMNYA ERROR)
            ->addColumn('technician_name', function ($row) {
                return $row->technician?->nama ?? '-';
            })

            // LIST SERVICE
            ->addColumn('services', function ($row) {
                return $row->details
                    ->pluck('service.nama')
                    ->filter()
                    ->implode(', ');
            })

            // GRAND TOTAL
            ->editColumn('grand_total', function ($row) {
                return 'Rp ' . number_format($row->grand_total, 0, ',', '.');
            })

            // STATUS BADGE (biar UI konsisten modern)
            ->addColumn('status_badge', function ($row) {

                if ($row->status === 'selesai') {
                    return '
                    <span class="px-3 py-1 text-xs rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100 font-semibold">
                        Selesai
                    </span>
                ';
                }

                return '
                <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-600 font-semibold">
                    ' . ucfirst($row->status) . '
                </span>
            ';
            })

            ->rawColumns([
                'status_badge'
            ])

            ->make(true);
    }

    public function exportPdf(Request $request)
    {
        $query = ServiceOrder::with(['customer', 'technician']);

        // 🔥 DEFAULT RANGE (1 - akhir bulan saat ini)
        $start = $request->start_date
            ? Carbon::parse($request->start_date)->startOfDay()
            : now()->startOfMonth();

        $end = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : now()->endOfMonth();

        // FILTER DATA
        $query->whereBetween('created_at', [$start, $end]);

        $data = $query->latest()->get();

        $pdf = Pdf::loadView('admin.reports.service-orders.pdf', [
            'data'  => $data,
            'start' => $start,
            'end'   => $end,
        ])->setPaper('a4', 'landscape');

        // ✅ RETURN YANG BENAR
        return $pdf->stream('laporan-servis.pdf');
    }
    /*
    |--------------------------------------------------------------------------
    | LAPORAN PENDAPATAN
    |--------------------------------------------------------------------------
    */

    public function revenue(Request $request)
    {
        $query = ServiceOrder::query();

        // 🔥 DEFAULT RANGE (bulan ini)
        $start = $request->start_date
            ? Carbon::parse($request->start_date)->startOfDay()
            : now()->startOfMonth();

        $end = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : now()->endOfMonth();

        $query->whereBetween('created_at', [$start, $end]);

        $totalRevenue = (clone $query)->sum('grand_total');
        $totalTransaksi = (clone $query)->count();

        $avgRevenue = $totalTransaksi
            ? $totalRevenue / $totalTransaksi
            : 0;

        return view('admin.reports.revenue', compact(
            'totalRevenue',
            'totalTransaksi',
            'avgRevenue',
            'start',
            'end'
        ));
    }

    public function revenueData(Request $request)
    {
        $query = ServiceOrder::with('customer', 'invoice');

        $start = $request->start_date
            ? Carbon::parse($request->start_date)->startOfDay()
            : now()->startOfMonth();

        $end = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : now()->endOfMonth();

        $query->whereBetween('created_at', [$start, $end]);

        return DataTables::of($query)

            ->addColumn('customer_name', fn($row) => $row->customer?->nama ?? '-')

            ->addColumn('invoice_number', fn($row) => $row->invoice?->nomor_invoice ?? '-')

            ->editColumn(
                'grand_total',
                fn($row) =>
                'Rp ' . number_format($row->grand_total, 0, ',', '.')
            )

            ->editColumn(
                'created_at',
                fn($row) =>
                $row->created_at->format('d/m/Y')
            )

            ->make(true);
    }

    public function revenueExportPdf(Request $request)
    {
        $query = ServiceOrder::with('customer', 'invoice');

        $start = $request->start_date
            ? Carbon::parse($request->start_date)->startOfDay()
            : now()->startOfMonth();

        $end = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : now()->endOfMonth();

        $query->whereBetween('created_at', [$start, $end]);

        $data = $query->latest()->get();

        $pdf = Pdf::loadView('admin.reports.revenue.pdf', [
            'data' => $data,
            'start' => $start,
            'end' => $end,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-pendapatan.pdf');
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN CUSTOMER
    |--------------------------------------------------------------------------
    */

    public function customers(Request $request)
    {
        $query = Customer::query();

        // filter global (optional)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereHas('serviceOrders', function ($q) use ($request) {
                $q->whereBetween('created_at', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59'
                ]);
            });
        }

        $totalCustomer = (clone $query)->count();

        $customerAktif = (clone $query)
            ->whereHas('serviceOrders')
            ->count();

        return view('admin.reports.customers', compact(
            'totalCustomer',
            'customerAktif'
        ));
    }

    public function customersData(Request $request)
    {
        $query = Customer::withCount(['serviceOrders' => function ($q) use ($request) {

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $q->whereBetween('created_at', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59'
                ]);
            }
        }]);

        return DataTables::of($query)

            ->addColumn('nama', fn($row) => $row->nama)
            ->addColumn('telepon', fn($row) => $row->telepon)
            ->addColumn('alamat', fn($row) => $row->alamat ?? '-')

            ->addColumn('total_order', function ($row) {
                return '
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                    ' . $row->service_orders_count . ' Order
                </span>
            ';
            })

            ->rawColumns(['total_order'])
            ->make(true);
    }

    public function exportCustomerPdf(Request $request)
    {
        $query = Customer::withCount(['serviceOrders' => function ($q) use ($request) {

            if ($request->filled('start_date') && $request->filled('end_date')) {
                $q->whereBetween('created_at', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59'
                ]);
            }
        }]);

        $data = $query->orderBy('nama')->get();

        $start = $request->filled('start_date')
            ? Carbon::parse($request->start_date)->startOfDay()
            : Carbon::now()->startOfMonth();

        $end = $request->filled('end_date')
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::now()->endOfMonth();

        return Pdf::loadView('admin.reports.customers.pdf', [
            'data' => $data,
            'start' => $start,
            'end' => $end,
            'generatedAt' => now(),
        ])
            ->setPaper('a4', 'portrait')
            ->stream('laporan-customer.pdf');
    }
}
