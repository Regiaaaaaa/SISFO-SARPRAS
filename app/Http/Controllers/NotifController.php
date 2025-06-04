<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotifController extends Controller
{
    /**
     * Get all notifications for a user
     */
    public function index($userId): JsonResponse
    {
        try {
            $notifications = Notification::forUser($userId)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $notifications,
                'unread_count' => $notifications->where('is_read', false)->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil notifikasi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark single notification as read
     */
    public function markAsRead($notificationId): JsonResponse
    {
        try {
            $notification = Notification::find($notificationId);
            
            if (!$notification) {
                return response()->json([
                    'success' => false,
                    'message' => 'Notifikasi tidak ditemukan'
                ], 404);
            }

            $notification->update(['is_read' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Notifikasi berhasil ditandai sebagai dibaca'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menandai notifikasi sebagai dibaca',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark all notifications as read for a user
     */
    public function markAllAsRead($userId): JsonResponse
    {
        try {
            Notification::forUser($userId)
                ->unread()
                ->update(['is_read' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Semua notifikasi berhasil ditandai sebagai dibaca'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menandai semua notifikasi sebagai dibaca',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete old notifications (cleanup job)
     */
    public function cleanup(): JsonResponse
    {
        try {
            // Hapus notifikasi yang sudah dibaca dan lebih dari 30 hari
            $deletedCount = Notification::where('is_read', true)
                ->where('created_at', '<', now()->subDays(30))
                ->delete();

            return response()->json([
                'success' => true,
                'message' => "Berhasil menghapus {$deletedCount} notifikasi lama"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membersihkan notifikasi lama',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}