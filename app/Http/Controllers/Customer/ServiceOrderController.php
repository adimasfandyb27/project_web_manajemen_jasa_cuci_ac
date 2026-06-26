<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Service;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceOrderController extends Controller
{
    public function index()
    {
        $customer = Customer::where('user_id', auth()->id())->first();

        if (!$customer) {
            return back()->with('error', 'Customer tidak ditemukan');
        }

        $orders = ServiceOrder::where('customer_id', $customer->id)
            ->latest()
            ->get();

        return view('customer.orders.index', compact('orders'));
    }


    public function create()
    {
        $customer = Customer::where('user_id', auth()->id())->first();

        if (!$customer) {
            return redirect()
                ->route('customer.dashboard')
                ->with('error', 'Data customer tidak ditemukan.');
        }

        if (empty($customer->telepon)) {
            return redirect()
                ->route('customer.profile.edit')
                ->with('warning', 'Silakan lengkapi nomor telepon terlebih dahulu sebelum membuat order service.');
        }

        $services = Service::all();

        return view('customer.orders.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alamat_servis' => 'required',
            'tanggal_order' => 'required',
            'jadwal_servis' => 'required|date|after_or_equal:today',

            'items' => 'required|array|min:1',
            'items.*.service_id' => 'required|exists:services,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        $customer = Customer::where('user_id', auth()->id())->first();

        if (!$customer) {
            return back()->with('error', 'Data customer tidak ditemukan');
        }

        if (empty($customer->telepon)) {
            return redirect()
                ->route('customer.profile.edit')
                ->with('warning', 'Silakan lengkapi nomor telepon terlebih dahulu sebelum membuat order service.');
        }

        if ($this->isKuotaPenuh($request->jadwal_servis)) {
            return back()
                ->withInput()
                ->withErrors([
                    'jadwal_servis' => 'Kuota servis pada tanggal tersebut sudah penuh. Silakan pilih tanggal lain.'
                ]);
        }

        DB::transaction(function () use ($request, $customer) {

            // =========================
            // CREATE ORDER
            // =========================
            $order = ServiceOrder::create([
                'nomor_order' => ServiceOrder::generateKode(),
                'customer_id' => $customer->id,
                'tanggal_order' => $request->tanggal_order,
                'jadwal_servis' => $request->jadwal_servis,
                'alamat_servis' => $request->alamat_servis,
                'keluhan' => $request->keluhan,
                'status' => 'pending',
                'subtotal_jasa' => 0,
                'subtotal_sparepart' => 0,
                'diskon' => 0,
                'grand_total' => 0,
            ]);

            // =========================
            // SIMPAN DETAIL LAYANAN
            // =========================
            $subtotalJasa = 0;

            foreach ($request->items as $item) {

                $service = Service::findOrFail($item['service_id']);

                $subtotal = $service->harga * $item['qty'];

                ServiceOrderDetail::create([
                    'service_order_id' => $order->id,
                    'service_id' => $service->id,
                    'harga' => $service->harga,
                    'qty' => $item['qty'],
                    'subtotal' => $subtotal,
                ]);

                $subtotalJasa += $subtotal;
            }

            // =========================
            // UPDATE TOTAL ORDER
            // =========================
            $order->update([
                'subtotal_jasa' => $subtotalJasa,
                'grand_total' => $subtotalJasa,
            ]);

            // =========================
            // ACTIVITY LOG
            // =========================
            activity()
                ->causedBy(auth()->user())
                ->performedOn($order)
                ->event('create')
                ->withProperties([
                    'nomor_order' => $order->nomor_order,
                    'customer_id' => $customer->id,
                    'total' => $order->grand_total,
                    'ip' => $request->ip(),
                    'module' => 'Customer Order',
                ])
                ->log('Customer membuat order servis');
        });

        return redirect()
            ->route('customer.orders')
            ->with('success', 'Order berhasil dikirim');
    }

    public function show($id)
    {
        $customer = Customer::where('user_id', auth()->id())->first();

        if (!$customer) {
            abort(404);
        }

        $order = ServiceOrder::where('id', $id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();

        return view('customer.orders.show', compact('order'));
    }

    public function edit($id)
    {
        $customer = Customer::where('user_id', auth()->id())->first();

        $order = ServiceOrder::where('id', $id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();

        if ($order->status !== 'pending') {
            return redirect()->route('customer.orders')
                ->with('error', 'Order tidak bisa diedit lagi');
        }

        $order->load('details.service');

        $services = Service::all();

        return view('customer.orders.edit', compact('order', 'services'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::where('user_id', auth()->id())->first();

        $order = ServiceOrder::where('id', $id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();

        if ($order->status !== 'pending') {
            return back()->with('error', 'Order tidak bisa diubah');
        }

        $request->validate([
            'alamat_servis' => 'required',
            'jadwal_servis' => 'required|date|after_or_equal:today',
            'items' => 'required|array|min:1',
            'items.*.service_id' => 'required|exists:services,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        // cek kuota jika tanggal berubah
        if (
            $request->jadwal_servis != $order->jadwal_servis &&
            $this->isKuotaPenuh($request->jadwal_servis, $order->id)
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'jadwal_servis' => 'Kuota servis pada tanggal tersebut sudah penuh.'
                ]);
        }

        DB::transaction(function () use ($request, $order, $customer) {

            // =========================
            // UPDATE ORDER
            // =========================
            $order->update([
                'alamat_servis' => $request->alamat_servis,
                'jadwal_servis' => $request->jadwal_servis,
                'keluhan' => $request->keluhan,
            ]);

            // =========================
            // HAPUS DETAIL LAMA
            // =========================
            $order->details()->delete();

            // =========================
            // INSERT DETAIL BARU
            // =========================
            $subtotalJasa = 0;

            foreach ($request->items as $item) {

                $service = Service::findOrFail($item['service_id']);

                $subtotal = $service->harga * $item['qty'];

                ServiceOrderDetail::create([
                    'service_order_id' => $order->id,
                    'service_id' => $service->id,
                    'harga' => $service->harga,
                    'qty' => $item['qty'],
                    'subtotal' => $subtotal,
                ]);

                $subtotalJasa += $subtotal;
            }

            // =========================
            // UPDATE TOTAL
            // =========================
            $order->update([
                'subtotal_jasa' => $subtotalJasa,
                'grand_total' => $subtotalJasa,
            ]);

            // =========================
            // LOG
            // =========================
            activity()
                ->causedBy(auth()->user())
                ->performedOn($order)
                ->event('update')
                ->withProperties([
                    'nomor_order' => $order->nomor_order,
                    'total' => $order->grand_total,
                    'ip' => $request->ip(),
                    'module' => 'Customer Order',
                ])
                ->log('Customer mengupdate order servis');
        });

        return redirect()
            ->route('customer.orders')
            ->with('success', 'Order berhasil diupdate');
    }

    public function cancel(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required|min:10|max:500'
        ], [
            'cancel_reason.required' => 'Alasan pembatalan wajib diisi.',
            'cancel_reason.min' => 'Alasan pembatalan minimal 10 karakter.',
        ]);

        $customer = Customer::where('user_id', auth()->id())->first();

        $order = ServiceOrder::where('id', $id)
            ->where('customer_id', $customer->id)
            ->firstOrFail();

        if ($order->status !== 'pending') {
            return back()->with(
                'error',
                'Order tidak dapat dibatalkan karena sedang diproses.'
            );
        }

        $order->update([
            'status' => 'dibatalkan',
            'cancel_reason' => $request->cancel_reason,
            'cancelled_at' => Carbon::now(),
        ]);

        activity()
            ->causedBy(auth()->user())
            ->performedOn($order)
            ->event('cancel')
            ->withProperties([
                'nomor_order' => $order->nomor_order,
                'alasan' => $request->cancel_reason,
                'ip' => $request->ip(),
                'module' => 'Customer Order',
            ])
            ->log('Customer membatalkan order servis');

        return redirect()
            ->route('customer.orders')
            ->with('success', 'Order berhasil dibatalkan.');
    }

    private function isKuotaPenuh($tanggal, $excludeOrderId = null)
    {
        $maxOrderPerDay = 30; // bisa dipindah ke config atau settings

        $query = ServiceOrder::whereDate('jadwal_servis', $tanggal);

        // untuk edit order, abaikan order yang sedang diedit
        if ($excludeOrderId) {
            $query->where('id', '!=', $excludeOrderId);
        }

        return $query->count() >= $maxOrderPerDay;
    }
}
