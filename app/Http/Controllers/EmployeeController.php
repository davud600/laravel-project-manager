<?php

namespace App\Http\Controllers;

use App\Models\EmployeeEstimatedTime;
use App\Models\Project;
use App\Models\ProjectEmployee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function dashboard()
    {
        $employees_project_ids = array_column(
            ProjectEmployee::where('employee_id', auth()->user()->id)
                ->get()->toArray(),
            'projecT_id'
        );
        $employees_activity = EmployeeEstimatedTime::where(
            'employee_id',
            auth()->user()->id
        )->get();
        $projects = Project::where('id', $employees_project_ids)->get();

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

        return view('employee.dashboard', [
            'projects' => $projects,
            'employees_activity' => $employees_activity
        ]);
    }
}
