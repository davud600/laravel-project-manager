<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected function employeeId(): Attribute
    {
        return Attribute::make(
            set: fn () => auth()->user()->id
        );
    }

    protected function timeAdded(): Attribute
    {
        return Attribute::make(
            set: fn () => getTimeFromHoursAndMinutes(
                request()->post('hours'),
                request()->post('minutes')
            )
        );
    }

    protected function createdByAdmin(): Attribute
    {
        return Attribute::make(
            set: fn () => auth()->user()->role == 1
        );
    }

    public function getEmployeeActivity(
        bool $withEmployee = false,
        bool $withProject = false
    ): Collection {
        return
            $this->where('created_by_admin', false)
            ->when($withEmployee, function ($query) {
                $query->with('employee');
            })->when($withProject, function ($query) {
                $query->with('project');
            })
            ->get();
    }

    public function getActivityOfEmployee(
        $employeeId,
        bool $withEmployee = false,
        bool $withProject = false
    ): Collection {
        return $this->where('employee_id', $employeeId)
            ->when($withEmployee, function ($query) {
                $query->with('employee');
            })->when($withProject, function ($query) {
                $query->with('project');
            })
            ->get();
    }

    public function getActivityOfProject(
        $projectId,
        bool $withEmployee = false,
        bool $withProject = false
    ): Collection {
        return $this->where('project_id', $projectId)
            ->when($withEmployee, function ($query) {
                $query->with('employee');
            })->when($withProject, function ($query) {
                $query->with('project');
            })
            ->get();
    }
}
