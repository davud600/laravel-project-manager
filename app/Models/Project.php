<?php

namespace App\Models;

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
}
