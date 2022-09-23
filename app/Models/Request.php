<?php

namespace App\Models;

use App\Jobs\SendEmailJob;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

        static::created(function (Request $request) {
            $projectEmployees = $request->project->employees->pluck('employee');

            foreach ($projectEmployees as $employee) {
                Notification::create([
                    'user_id' => $employee->id,
                    'created_by' => auth()->user()->id,
                    'type' => 5
                ]);

                SendEmailJob::dispatch(
                    $employee->email,
                    [
                        'name' => 'One of your projects has a new request',
                        'dob' => now()
                    ]
                );
            }
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->with('user');
    }

    protected function projectId(): Attribute
    {
        return Attribute::make(
            set: fn () => request()->get('project_id')
        );
    }

    public function getById($id): Request
    {
        return $this->where('id', $id)
            ->first();
    }
}
