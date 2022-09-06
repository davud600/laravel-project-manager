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
        });
    }

    public function getProjectsOfCustomer($customerId): Collection
    {
        return $this->where('customer_id', $customerId)
            ->get();
    }

    public function getProjectsFromIds(array $projectIds): Collection
    {
        return $this->where('id', $projectIds)
            ->get();
    }

    public function getById($id): Project
    {
        return $this->where('id', $id)
            ->first();
    }
}
