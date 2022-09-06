<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
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
        static::deleted(function (Request $request) {
            // delete request messages
            Message::where('request_id', $request->id)
                ->delete();
        });
    }

    public function getById($id): Request
    {
        return $this->where('id', $id)
            ->first();
    }

    public function getRequestsOfProject($projectId): Collection
    {
        return $this->where('project_id', $projectId)
            ->get();
    }
}
