<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'project_id',
        'status'
    ];

    protected static function booted()
    {
        static::deleted(function ($request) {
            // delete request messages
            Message::where('request_id', $request->id)
                ->delete();
        });
    }
}
