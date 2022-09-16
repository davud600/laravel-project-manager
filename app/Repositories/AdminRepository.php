<?php

namespace App\Repositories;

use App\Models\EmployeeEstimatedTime;
use App\Models\Project;
use Illuminate\Contracts\View\View;

class AdminRepository implements RepositoryInterface
{
    static public function dashboard(array $filters): View
    {
        $projects = Project::filter($filters)
            ->with('customer')
            ->get();

        $estimatedTimes = new EmployeeEstimatedTime;

        $employeeActivity = $estimatedTimes->getEmployeeActivity(
            withEmployee: true,
            withProject: true
        );

        return view('admin.dashboard', [
            'projects' => $projects,
            'employees_activity' => $employeeActivity
        ]);
    }
}
