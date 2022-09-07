<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeEstimatedTime extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'employee_id',
        'project_id',
        'time_added',
        'created_by_admin'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class);
    }

    public function getEmployeeActivity(): Collection
    {
        return $this->where('created_by_admin', false)
            ->get();
    }

    public function getActivityOfEmployee($employeeId): Collection
    {
        return $this->where('employee_id', $employeeId)
            ->get();
    }

    public function getActivityOfProject($projectId): Collection
    {
        return $this->where('project_id', $projectId)
            ->get();
    }
}
