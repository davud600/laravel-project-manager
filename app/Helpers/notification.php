<?php

use App\Models\Message;
use App\Models\Notification as ModelsNotification;
use App\Models\UserReadMessage;
use App\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;

if (!function_exists('getUnreadMessages')) {
    function getUnreadMessages(): array
    {
        $allMessages = Message::with('user')
            ->where('created_by', '!=', auth()->user()->id)
            ->with('request')
            ->with('user')
            ->get();
        $readMessages = UserReadMessage::select('message_id as id')
            ->get()->toArray(); // Ids
        $unreadMessages = [];


        foreach ($allMessages as $message) {
            if (!in_array(['id' => $message->id], $readMessages)) {
                array_push($unreadMessages, $message);
            }
        }

        return array_reverse($unreadMessages);
    }
}

if (!function_exists('getUnreadNotifications')) {
    function getUnreadNotifications(): Collection
    {
        $unreadNotifications = ModelsNotification::where('user_id', auth()->user()->id)
            ->where('read', false)
            ->with('creator')
            ->get()
            ->reverse();

        return $unreadNotifications;
    }
}

if (!function_exists('getNotificationType')) {
    function getNotificationType($typeId): string
    {
        return Notification::type[$typeId];
    }
}
