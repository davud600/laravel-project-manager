<?php

namespace App\Http\Controllers;

use App\Models\EmployeeEstimatedTime;
use App\Models\Project;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $projects = Project::all();
        $employees_activity = EmployeeEstimatedTime::all();

        foreach ($projects as $project) {
            $project->estimated_time = getHoursAndMinutesFromTime(
                $project->estimated_time
            );
            $project->customer_id = getUserNameFromId(
                $project->customer_id
            );
        }

        foreach ($employees_activity as $employee_activity) {
            $employee_activity->time_added = getHoursAndMinutesFromTime(
                $employee_activity->time_added
            );
            $employee_activity->employee_id = getUserNameFromId(
                $employee_activity->employee_id
            );
            $employee_activity->project_id = getProjectTitleFromId(
                $employee_activity->project_id
            );
        }

        return view('admin.dashboard', [
            'projects' => $projects,
            'employees_activity' => $employees_activity
        ]);
    }
}
