<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use Illuminate\Http\JsonResponse;

class AdminNotificationController extends Controller
{
    public function unread(): JsonResponse
    {
        $notifications = AdminNotification::unread()
            ->latest()
            ->take(10)
            ->get();

        return response()->json([
            'data' => $notifications,
            'total' => AdminNotification::unread()->count(),
        ]);
    }

    public function markAsRead(AdminNotification $notification): JsonResponse
    {
        $notification->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    public function markAllAsRead(): JsonResponse
    {
        AdminNotification::unread()->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }
}
