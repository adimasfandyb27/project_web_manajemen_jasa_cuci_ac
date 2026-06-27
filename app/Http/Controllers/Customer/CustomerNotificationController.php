<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerNotification;
use Illuminate\Http\JsonResponse;

class CustomerNotificationController extends Controller
{
    public function unread(): JsonResponse
    {
        $customer = Customer::where('user_id', auth()->id())->first();
        if (! $customer) {
            return response()->json(['data' => []]);
        }

        $notifications = CustomerNotification::forCustomer($customer->id)
            ->unread()
            ->latest()
            ->take(10)
            ->get();

        return response()->json([
            'data' => $notifications,
            'total' => CustomerNotification::forCustomer($customer->id)->unread()->count(),
        ]);
    }

    public function markAsRead(CustomerNotification $notification): JsonResponse
    {
        $customer = Customer::where('user_id', auth()->id())->first();
        if (! $customer || $notification->customer_id !== $customer->id) {
            abort(403);
        }

        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function markAllAsRead(): JsonResponse
    {
        $customer = Customer::where('user_id', auth()->id())->first();
        if (! $customer) {
            return response()->json(['success' => false]);
        }

        CustomerNotification::forCustomer($customer->id)
            ->unread()
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}
