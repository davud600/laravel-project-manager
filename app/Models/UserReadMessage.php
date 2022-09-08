<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserReadMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'message_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function readMessages(
        Collection $messages,
        int $userId
    ) {
        foreach ($messages as $message) {
            if ($message->created_by === $userId) {
                continue;
            }

            $messageHasBeenReadBefore = $this->where('user_id', $userId)
                ->where('message_id', $message->id)
                ->first() !== null;

            if ($messageHasBeenReadBefore) {
                continue;
            }

            $this->create([
                'user_id' => $userId,
                'message_id' => $message->id
            ]);
        }
    }
}
