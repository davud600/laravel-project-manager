<?php

use App\Models\Message;
use App\Models\UserReadMessage;

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
            // check if $readMessages contains message
            if (!in_array(['id' => $message->id], $readMessages)) {
                array_push($unreadMessages, $message);
            }
        }

        return array_reverse($unreadMessages);
    }
}
