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
