<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Service;
use App\Models\ServiceOrder;
use App\Models\Technician;
use Illuminate\Http\Request;

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

        return view('admin.dashboard', compact(
            'totalCustomer',
            'totalTechnician',
            'totalService',
            'totalOrder',
            'totalRevenue',
            'monthlyRevenue',
            'orderStatus'
        ));
    }
}
