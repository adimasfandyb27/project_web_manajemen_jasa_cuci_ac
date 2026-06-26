<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderDetail;
use App\Models\Technician;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ServiceOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = ServiceOrder::with([
                'customer',
                'technician'
            ]);

            if ($request->filled('tanggal_dari')) {

                $query->whereDate(
                    'tanggal_order',
                    '>=',
                    $request->tanggal_dari
                );
            }

            if ($request->filled('tanggal_sampai')) {

                $query->whereDate(
                    'tanggal_order',
                    '<=',
                    $request->tanggal_sampai
                );
            }

            return DataTables::of($query)

                ->addColumn('customer', function ($row) {
                    return $row->customer?->nama ?? '-';
                })

                ->addColumn('teknisi', function ($row) {
                    return $row->technician?->nama ?? '-';
                })

                ->editColumn('tanggal_order', function ($row) {
                    return $row->tanggal_order
                        ? \Carbon\Carbon::parse($row->tanggal_order)->format('d/m/Y')
                        : '-';
                })

                ->editColumn('jadwal_servis', function ($row) {
                    return $row->jadwal_servis
                        ? \Carbon\Carbon::parse($row->jadwal_servis)->format('d/m/Y')
                        : '-';
                })

                ->editColumn('grand_total', function ($row) {
                    return 'Rp ' . number_format($row->grand_total, 0, ',', '.');
                })

                ->addColumn('status_badge', function ($row) {

                    return match ($row->status) {

                        'pending' =>
                        '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Pending</span>',

                        'dijadwalkan' =>
                        '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Dijadwalkan</span>',

                        'proses' =>
                        '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">Proses</span>',

                        'selesai' =>
                        '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Selesai</span>',

                        'dibatalkan' =>
                        '<span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Dibatalkan</span>',

                        default => '-',
                    };
                })

                // ->addColumn('aksi', function ($row) {

                //     $show = route('admin.service-orders.show', $row->id);
                //     $edit = route('admin.service-orders.edit', $row->id);

                //     return '
                //     <div class="flex justify-center gap-2">

                //         <a href="' . $show . '"
                //            class="px-3 py-2 rounded-lg bg-sky-500 hover:bg-sky-600 text-white text-xs">
                //             Detail
                //         </a>

                //         <a href="' . $edit . '"
                //            class="px-3 py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-xs">
                //             Edit
                //         </a>

                //     </div>
                // ';
                // })
                ->addColumn('aksi', function ($row) {
                    return [
                        'id' => $row->id
                    ];
                })

                ->rawColumns([
                    'status_badge',
                    'aksi'
                ])

                ->make(true);
        }

        return view('admin.service-orders.index', [
            'totalOrder'   => ServiceOrder::count(),
            'totalProses'  => ServiceOrder::where('status', 'proses')->count(),
            'totalSelesai' => ServiceOrder::where('status', 'selesai')->count(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::orderBy('nama')->get();
        $technicians = Technician::where('status', 'aktif')
            ->whereNotNull('status')
            ->whereRaw("status != 'nonaktif'")
            ->get();
        $services = Service::orderBy('nama_layanan')->get();

        $kode_layanan = ServiceOrder::generateKode();
        return view('admin.service-orders.create', compact(
            'customers',
            'technicians',
            'services',
            'kode_layanan'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'tanggal_order' => 'required',
            'alamat_servis' => 'required',
            'items' => 'required|array|min:1',
        ]);

        DB::transaction(function () use ($request) {

            $order = ServiceOrder::create([
                'nomor_order' => ServiceOrder::generateKode(),
                'customer_id' => $request->customer_id,
                'technician_id' => $request->technician_id,
                'tanggal_order' => $request->tanggal_order,
                'jadwal_servis' => $request->jadwal_servis,
                'alamat_servis' => $request->alamat_servis,
                'keluhan' => $request->keluhan,
                'status' => 'pending',
                'subtotal_jasa' => 0,
                'subtotal_sparepart' => $request->subtotal_sparepart ?? 0,
                'diskon' => $request->diskon ?? 0,
                'grand_total' => 0,
                'catatan' => $request->catatan,
            ]);

            $subtotal = 0;

            foreach ($request->items as $item) {

                $service = Service::findOrFail(
                    $item['service_id']
                );

                $qty = $item['qty'];

                $lineSubtotal =
                    $service->harga * $qty;

                ServiceOrderDetail::create([
                    'service_order_id' => $order->id,
                    'service_id' => $service->id,
                    'harga' => $service->harga,
                    'qty' => $qty,
                    'subtotal' => $lineSubtotal,
                    'keterangan' => $item['keterangan'] ?? null,
                ]);

                $subtotal += $lineSubtotal;
            }

            $grandTotal =
                $subtotal
                + ($request->subtotal_sparepart ?? 0)
                - ($request->diskon ?? 0);

            $order->update([
                'subtotal_jasa' => $subtotal,
                'subtotal_sparepart' => $request->subtotal_sparepart ?? 0,
                'grand_total' => $grandTotal,
            ]);

            activity()
                ->causedBy(auth()->user())
                ->performedOn($order)
                ->event('create')
                ->withProperties([
                    'nomor_order' => $order->nomor_order,
                    'customer' => $order->customer_id,
                    'technician' => $order->technician_id,
                    'subtotal_jasa' => $subtotal,
                    'subtotal_sparepart' => $request->subtotal_sparepart ?? 0,
                    'diskon' => $request->diskon ?? 0,
                    'grand_total' => $grandTotal,
                    'ip' => $request->ip(),
                ])
                ->log('Membuat order servis baru');
        });

        return redirect()
            ->route('admin.service-orders.index')
            ->with('success', 'Order servis berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceOrder $serviceOrder)
    {
        $serviceOrder->load([
            'customer',
            'technician',
            'details.service'
        ]);

        return view(
            'admin.service-orders.show',
            compact('serviceOrder')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceOrder $serviceOrder)
    {
        $serviceOrder->load('details');

        $customers = Customer::all();
        $technicians = Technician::where('status', 'aktif')
            ->orWhere('id', $serviceOrder->technician_id)
            ->get();
        $services = Service::all();

        // dd($serviceOrder->details->toArray());
        $items = $serviceOrder->details->map(function ($detail) {
            return [
                'service_id' => $detail->service_id,
                'harga'      => $detail->harga,
                'qty'        => $detail->qty,
                'subtotal'   => $detail->subtotal,
            ];
        })->values();

        return view(
            'admin.service-orders.edit',
            compact(
                'serviceOrder',
                'customers',
                'technicians',
                'services',
                'items'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceOrder $serviceOrder)
    {
        try {

            DB::transaction(function () use ($request, $serviceOrder) {


                // ==================================
                // VALIDASI FLOW STATUS
                // ==================================
                $oldStatus = $serviceOrder->status;

                $newStatus = $request->status;

                if ($oldStatus !== $newStatus) {

                    $statusFlow = [
                        'pending' => ['dijadwalkan', 'dibatalkan'],
                        'dijadwalkan' => ['proses', 'dibatalkan'],
                        'proses' => ['selesai'],
                        'selesai' => [],
                        'dibatalkan' => [],
                    ];

                    if (
                        isset($statusFlow[$oldStatus]) &&
                        !in_array($newStatus, $statusFlow[$oldStatus])
                    ) {
                        throw new \Exception('Perubahan status tidak valid.');
                    }
                }



                // ==================================
                // HAPUS DETAIL LAMA
                // ==================================

                $serviceOrder->details()->delete();

                $subtotalJasa = 0;

                foreach ($request->items as $item) {

                    $service = Service::findOrFail(
                        $item['service_id']
                    );

                    $lineSubtotal =
                        $service->harga *
                        $item['qty'];

                    ServiceOrderDetail::create([
                        'service_order_id' => $serviceOrder->id,
                        'service_id' => $service->id,
                        'harga' => $service->harga,
                        'qty' => $item['qty'],
                        'subtotal' => $lineSubtotal,
                        'keterangan' => $item['keterangan'] ?? null,
                    ]);

                    $subtotalJasa += $lineSubtotal;
                }

                $subtotalSparepart =
                    $request->subtotal_sparepart ?? 0;

                $diskon =
                    $request->diskon ?? 0;

                $grandTotal =
                    $subtotalJasa +
                    $subtotalSparepart -
                    $diskon;

                // ==================================
                // CEK DP SEBELUM PROSES
                // ==================================

                $invoice = $serviceOrder->invoice;

                if ($request->status === 'proses') {

                    if (!$invoice) {
                        throw new \Exception('Invoice belum dibuat.');
                    }

                    $totalPaid = $invoice->payments()
                        ->where('status', 'verified')
                        ->sum('amount');

                    $minDP = $invoice->total * 0.5;

                    if ($totalPaid < $minDP) {
                        throw new \Exception('Minimal DP 50% atau pelunasan penuh harus dilakukan sebelum proses.');
                    }
                }

                // ==================================
                // UPDATE SERVICE ORDER
                // ==================================

                $serviceOrder->update([
                    'customer_id' => $request->customer_id,
                    'technician_id' => $request->technician_id,
                    'tanggal_order' => $request->tanggal_order,
                    'jadwal_servis' => $request->jadwal_servis,
                    'alamat_servis' => $request->alamat_servis,
                    'keluhan' => $request->keluhan,
                    'status' => $request->status,
                    'diskon' => $diskon,
                    'subtotal_jasa' => $subtotalJasa,
                    'subtotal_sparepart' => $subtotalSparepart,
                    'grand_total' => $grandTotal,
                    'catatan' => $request->catatan,
                ]);

                activity()
                    ->causedBy(auth()->user())
                    ->performedOn($serviceOrder)
                    ->event('update')
                    ->withProperties([
                        'nomor_order' => $serviceOrder->nomor_order,
                        'status_lama' => $oldStatus,
                        'status_baru' => $request->status,
                        'grand_total' => $grandTotal,
                        'ip' => $request->ip(),
                    ])
                    ->log('Memperbarui order servis');

                // ==================================
                // AUTO CREATE INVOICE
                // ==================================

                if (
                    $oldStatus !== 'dijadwalkan' &&
                    $request->status === 'dijadwalkan' &&
                    !$serviceOrder->invoice
                ) {

                    $invoice = Invoice::create([
                        'nomor_invoice' => Invoice::generateNomor(),
                        'service_order_id' => $serviceOrder->id,
                        'tanggal_invoice' => now(),
                        'subtotal' => $grandTotal,
                        'diskon' => 0,
                        'total' => $grandTotal,
                        'status' => 'belum_bayar',
                    ]);

                    activity()
                        ->causedBy(auth()->user())
                        ->performedOn($invoice)
                        ->event('create')
                        ->withProperties([
                            'nomor_invoice' => $invoice->nomor_invoice,
                            'nomor_order' => $serviceOrder->nomor_order,
                            'total' => $invoice->total,
                        ])
                        ->log(
                            'Invoice otomatis dibuat karena order dijadwalkan'
                        );
                }
            });

            return redirect()
                ->route('admin.service-orders.index')
                ->with(
                    'success',
                    'Order berhasil diperbarui'
                );
        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceOrder $serviceOrder)
    {
        if ($serviceOrder->invoice) {

            return back()->with(
                'error',
                'Order sudah memiliki invoice dan tidak dapat dihapus.'
            );
        }

        $serviceOrder->delete();

        return back()->with(
            'success',
            'Order berhasil dihapus.'
        );
    }

    public function exportPdf(Request $request)
    {
        $query = ServiceOrder::with([
            'customer',
            'technician'
        ])->latest();

        if ($request->filled('tanggal_dari')) {

            $query->whereDate(
                'tanggal_order',
                '>=',
                $request->tanggal_dari
            );
        }

        if ($request->filled('tanggal_sampai')) {

            $query->whereDate(
                'tanggal_order',
                '<=',
                $request->tanggal_sampai
            );
        }

        $orders = $query->get();

        $pdf = Pdf::loadView(
            'admin.service-orders.export',
            compact('orders')
        );

        return $pdf->stream(
            'laporan-data-pemesanan.pdf'
        );
    }
}
