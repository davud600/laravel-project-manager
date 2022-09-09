<?php

namespace App\Models;

use App\Mail\ProjectEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
        'estimated_time',
        'customer_id'
    ];

    protected static function booted()
    {
        static::deleted(function (Project $project) {
            // delete project employees
            ProjectEmployee::where('project_id', $project->id)
                ->delete();

            // delete project estimated time adds
            EmployeeEstimatedTime::where('project_id', $project->id)
                ->delete();

            // delete requests
            Request::where('project_id', $project->id)
                ->delete();

            // send notification to customer
            Notification::create([
                'user_id' => $project->customer_id,
                'created_by' => auth()->user()->id,
                'type' => 2
            ]);

            Mail::to($project->customer->email)
                ->send(new ProjectEmail(
                    [
                        'name' => 'One of your projects was deleted',
                        'dob' => now()
                    ]
                ));
        });

        static::created(function (Project $project) {
            Notification::create([
                'user_id' => $project->customer_id,
                'created_by' => auth()->user()->id,
                'type' => 0
            ]);

            Mail::to($project->customer->email)
                ->send(new ProjectEmail(
                    [
                        'name' => 'A new project was created for you',
                        'dob' => now()
                    ]
                ));
        });

        static::updated(function (Project $project) {
            Notification::create([
                'user_id' => $project->customer_id,
                'created_by' => auth()->user()->id,
                'type' => 1
            ]);

            Mail::to($project->customer->email)
                ->send(new ProjectEmail(
                    [
                        'name' => 'One of your projects was updated',
                        'dob' => now()
                    ]
                ));
        });
    }

    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    public function getProjectsOfCustomer(
        $customerId,
        bool $withCustomer = false
    ): Collection {
        return $this->where('customer_id', $customerId)
            ->when($withCustomer, function ($query) {
                $query->with('customer');
            })
            ->get();
    }

    public function getProjectsFromIds(
        array $projectIds,
        bool $withCustomer = false
    ): Collection {
        return $this->where('id', $projectIds)
            ->when($withCustomer, function ($query) {
                $query->with('customer');
            })
            ->get();
    }

    public function getById(
        $id,
        bool $withCustomer = false
    ): Project {
        return $this->where('id', $id)
            ->when($withCustomer, function ($query) {
                $query->with('customer');
            })
            ->first();
    }
}
