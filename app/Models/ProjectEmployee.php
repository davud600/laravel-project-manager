<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectEmployee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'employee_id'
    ];

    public static function booted()
    {
        static::deleted(function (ProjectEmployee $projectEmployee) {
            // send notification to employee
            Notification::create([
                'user_id' => $projectEmployee->employee_id,
                'created_by' => auth()->user()->id,
                'type' => 4
            ]);
        });

        static::updated(function (ProjectEmployee $projectEmployee) {
            Notification::create([
                'user_id' => $projectEmployee->employee_id,
                'created_by' => auth()->user()->id,
                'type' => 1
            ]);
        });

        static::created(function (ProjectEmployee $projectEmployee) {
            Notification::create([
                'user_id' => $projectEmployee->employee_id,
                'created_by' => auth()->user()->id,
                'type' => 3
            ]);
        });
    }

    public function getProjectsOfEmployee($employeeId): Collection
    {
        return $this->where('employee_id', $employeeId)
            ->get();
    }

    public function getEmployeesOfProject($projectId): Collection
    {
        return $this->select('employee_id')
            ->where('project_id', $projectId)
            ->get();
    }
}
