<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        });

        static::created(function (Project $project) {
            Notification::create([
                'user_id' => $project->customer_id,
                'created_by' => auth()->user()->id,
                'type' => 0
            ]);
        });

        static::updated(function (Project $project) {
            Notification::create([
                'user_id' => $project->customer_id,
                'created_by' => auth()->user()->id,
                'type' => 1
            ]);
        });
    }

    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    public function getProjectsOfCustomer($customerId, bool $withCustomer = false): Collection
    {
        return $withCustomer ?
            $this->where('customer_id', $customerId)
            ->with('customer')
            ->get() :
            $this->where('customer_id', $customerId)
            ->get();
    }

    public function getProjectsFromIds(array $projectIds, bool $withCustomer = false): Collection
    {
        return $withCustomer ?
            $this->where('id', $projectIds)
            ->with('customer')
            ->get() :
            $this->where('id', $projectIds)
            ->get();
    }

    public function getById($id, bool $withCustomer = false): Project
    {
        return $this->where('id', $id)
            ->when($withCustomer, function ($query) {
                $query->with('customer');
            })
            ->first();
    }
}
