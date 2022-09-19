<?php

namespace App\Models;

use App\Jobs\SendEmailJob;
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

            SendEmailJob::dispatch(
                $projectEmployee->employee->email,
                [
                    'name' => 'One of your projects was deleted',
                    'dob' => now()
                ]
            );
        });

        static::updated(function (ProjectEmployee $projectEmployee) {
            Notification::create([
                'user_id' => $projectEmployee->employee_id,
                'created_by' => auth()->user()->id,
                'type' => 1
            ]);

            SendEmailJob::dispatch(
                $projectEmployee->employee->email,
                [
                    'name' => 'One of your projects was updated',
                    'dob' => now()
                ]
            );
        });

        static::created(function (ProjectEmployee $projectEmployee) {
            // find projectEmployee row that has same project and employee
            ProjectEmployee::where('project_id', $projectEmployee->project_id)
                ->where('employee_id', $projectEmployee->employee_id)
                ->where('id', '!=', $projectEmployee->id)
                ->first();

            Notification::create([
                'user_id' => $projectEmployee->employee_id,
                'created_by' => auth()->user()->id,
                'type' => 3
            ]);

            SendEmailJob::dispatch(
                $projectEmployee->employee->email,
                [
                    'name' => 'You were added to a project as an employee',
                    'dob' => now()
                ]
            );
        });
    }

    public function employee()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getProjectsOfEmployee(int $employeeId, array $filters)
    {
        return $this->where('employee_id', $employeeId)
            ->with('project')
            ->with('project.customer')
            ->when(
                $filters['query'] ?? false,
                fn ($query, $search) =>
                $query->whereHas(
                    'project',
                    fn ($query) =>
                    $query->where('title', 'like', '%' . $search . '%')
                )
            )
            ->when(
                $filters['limit'] ?? false,
                fn ($query, $limit) =>
                $query->limit($limit)
            )
            ->when(
                $filters['customer'] ?? false,
                fn ($query, $customer) =>
                $query->whereHas(
                    'project',
                    fn ($query) =>
                    $query->where('customer_id', $customer)
                )
            )
            ->get()
            ->pluck('project');
    }
}
