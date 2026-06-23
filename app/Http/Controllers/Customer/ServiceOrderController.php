<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;

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

        return view('customer.orders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'alamat_servis' => 'required',
            'tanggal_order' => 'required',
            'jadwal_servis' => 'required|date|after_or_equal:today',
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

        // Cek kuota harian
        if ($this->isKuotaPenuh($request->jadwal_servis)) {

            return back()
                ->withInput()
                ->withErrors([
                    'jadwal_servis' => 'Kuota servis pada tanggal tersebut sudah penuh. Silakan pilih tanggal lain.'
                ]);
        }

        ServiceOrder::create([
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

        // optional: hanya boleh edit jika masih pending
        if ($order->status !== 'pending') {
            return redirect()->route('customer.orders')
                ->with('error', 'Order tidak bisa diedit lagi');
        }

        return view('customer.orders.edit', compact('order'));
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
            'keluhan' => 'nullable',
        ]);

        // hanya cek jika tanggal berubah
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

        $order->update([
            'alamat_servis' => $request->alamat_servis,
            'jadwal_servis' => $request->jadwal_servis,
            'keluhan' => $request->keluhan,
        ]);

        return redirect()
            ->route('customer.orders')
            ->with('success', 'Order berhasil diupdate');
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
