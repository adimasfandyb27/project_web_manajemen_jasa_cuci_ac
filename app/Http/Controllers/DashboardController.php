<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\ServiceOrder;
use App\Models\Technician;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $totalCustomer = Customer::count();
        $totalTechnician = Technician::count();
        $totalService = Service::count();
        $totalOrder = ServiceOrder::count();

        $totalRevenue = Invoice::where('status', 'lunas')->sum('total');

        $monthlyRevenue = Invoice::selectRaw('MONTH(tanggal_invoice) month, SUM(total) total')
            ->whereYear('tanggal_invoice', now()->year)
            ->where('status', 'lunas')
            ->groupBy('month')
            ->pluck('total', 'month');

        $orderStatus = ServiceOrder::selectRaw('status, COUNT(*) total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Average completion time (hours)
        $avgCompletionTime = ServiceOrder::where('status', 'selesai')
            ->whereNotNull('jadwal_servis')
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, jadwal_servis, updated_at)) as avg_hours')
            ->value('avg_hours');

        // Best technician (most completed orders)
        $bestTechnician = Technician::select('technicians.id', 'technicians.nama', DB::raw('COUNT(service_orders.id) as total'))
            ->leftJoin('service_orders', function ($join) {
                $join->on('technicians.id', '=', 'service_orders.technician_id')
                    ->where('service_orders.status', '=', 'selesai');
            })
            ->groupBy('technicians.id', 'technicians.nama')
            ->orderByDesc('total')
            ->first();

        // Most frequent customer
        $topCustomer = Customer::select('customers.id', 'customers.nama', DB::raw('COUNT(service_orders.id) as total'))
            ->leftJoin('service_orders', 'customers.id', '=', 'service_orders.customer_id')
            ->groupBy('customers.id', 'customers.nama')
            ->orderByDesc('total')
            ->first();

        return view('admin.dashboard', compact(
            'totalCustomer',
            'totalTechnician',
            'totalService',
            'totalOrder',
            'totalRevenue',
            'monthlyRevenue',
            'orderStatus',
            'avgCompletionTime',
            'bestTechnician',
            'topCustomer'
        ));
    }
}
