<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'text',
        'attach',
        'request_id',
        'created_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id', 'id');
    }

    public function getMessagesOfRequest($requestId, bool $withUser = false): Collection
    {
        return $this->where('request_id', $requestId)
            ->when($withUser, function ($query) {
                $query->with('user');
            })
            ->get();
    }
}
