<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\ServiceOrder;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $customer = Customer::where('user_id', auth()->id())->first();

        if (!$customer) {
            return view('customer.dashboard', [
                'totalOrders' => 0,
                'pendingOrders' => 0,
                'completedOrders' => 0,
                'latestOrders' => collect(),
            ]);
        }

        $totalOrders = ServiceOrder::where('customer_id', $customer->id)->count();

        $pendingOrders = ServiceOrder::where('customer_id', $customer->id)
            ->where('status', 'pending')
            ->count();

        $completedOrders = ServiceOrder::where('customer_id', $customer->id)
            ->where('status', 'selesai')
            ->count();

        $latestOrders = ServiceOrder::where('customer_id', $customer->id)
            ->latest()
            ->take(5)
            ->get();

        return view('customer.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'latestOrders'
        ));
    }
}
