<?php

namespace App\Repositories;

use App\Models\EmployeeEstimatedTime;
use App\Models\ProjectEmployee;
use Illuminate\Contracts\View\View;

class EmployeeRepository implements RepositoryInterface
{
    static public function dashboard(array $filters): View
    {
        $projectEmployee = new ProjectEmployee;
        $employeeEstimatedTime = new EmployeeEstimatedTime;

        $projects = $projectEmployee->getProjectsOfEmployee(
            auth()->user()->id,
            filters: $filters
        );

        $employeeActivity = $employeeEstimatedTime->getActivityOfEmployee(
            auth()->user()->id,
            withEmployee: true,
            withProject: true
        );

        return view('employee.dashboard', [
            'projects' => $projects,
            'employees_activity' => $employeeActivity
        ]);
    }
}
