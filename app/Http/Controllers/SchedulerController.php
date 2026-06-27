<?php

namespace App\Http\Controllers;

use App\Models\ServiceOrder;
use App\Models\Technician;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SchedulerController extends Controller
{
    public function index()
    {
        $technicians = Technician::where('status', 'aktif')->orderBy('nama')->get();

        return view('admin.scheduler.index', compact('technicians'));
    }

    public function events(Request $request)
    {
        $query = ServiceOrder::with(['customer', 'technician'])
            ->whereNotNull('jadwal_servis')
            ->whereNotIn('status', ['dibatalkan']);

        if ($request->filled('technician_id')) {
            $query->where('technician_id', $request->technician_id);
        }

        $orders = $query->get();

        $events = $orders->map(function ($order) {
            $color = match ($order->status) {
                'pending' => '#f59e0b',
                'dijadwalkan' => '#3b82f6',
                'proses' => '#f97316',
                'selesai' => '#10b981',
                default => '#6b7280',
            };

            $jadwal = Carbon::parse($order->jadwal_servis);

            return [
                'id' => $order->id,
                'title' => $order->customer?->nama.' - '.$order->technician?->nama,
                'start' => $jadwal->toIso8601String(),
                'color' => $color,
                'textColor' => '#fff',
                'extendedProps' => [
                    'nomor_order' => $order->nomor_order,
                    'customer' => $order->customer?->nama ?? '-',
                    'technician' => $order->technician?->nama ?? '-',
                    'status' => $order->status,
                    'alamat' => $order->alamat_servis,
                    'keluhan' => $order->keluhan,
                ],
                'url' => route('admin.service-orders.show', $order->id),
            ];
        });

        return response()->json($events);
    }

    public function technicianSchedule(Request $request, Technician $technician)
    {
        $date = $request->date ? Carbon::parse($request->date) : now();

        $orders = ServiceOrder::with('customer')
            ->where('technician_id', $technician->id)
            ->whereDate('jadwal_servis', $date)
            ->whereNotIn('status', ['dibatalkan', 'selesai'])
            ->orderBy('jadwal_servis')
            ->get();

        return response()->json([
            'technician' => $technician->nama,
            'date' => $date->format('Y-m-d'),
            'total_orders' => $orders->count(),
            'orders' => $orders->map(function ($o) {
                return [
                    'id' => $o->id,
                    'nomor_order' => $o->nomor_order,
                    'customer' => $o->customer?->nama ?? '-',
                    'jadwal' => $o->jadwal_servis,
                    'status' => $o->status,
                    'alamat' => $o->alamat_servis,
                ];
            }),
        ]);
    }
}
