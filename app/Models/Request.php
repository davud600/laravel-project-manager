<?php

namespace App\Models;

use App\Jobs\SendEmailJob;
use App\Mail\ProjectEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;

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
            $projectEmployee = new ProjectEmployee;
            $projectEmployees = $projectEmployee->getEmployeesOfProject($request->project_id);

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
