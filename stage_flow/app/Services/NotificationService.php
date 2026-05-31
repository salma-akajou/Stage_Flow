<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Collection;

class NotificationService extends BaseService
{
    public function __construct()
    {
        $this->model = new Notification();
    }

    public function createNotification(int $userId, string $type, string $title, string $message, array $data = []): Notification
    {
        return $this->create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'read_at' => null,
        ]);
    }

    public function markAsRead(int $id): bool
    {
        $notification = $this->findOrFail($id);
        return $notification->update(['read_at' => now()]);
    }

    public function markAllAsRead(int $userId): void
    {
        $this->model->where('user_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function getUnreadNotifications(int $userId, int $limit = 5): Collection
    {
        return $this->model->where('user_id', $userId)
            ->whereNull('read_at')
            ->latest()
            ->take($limit)
            ->get();
    }
}
