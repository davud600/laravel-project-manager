<?php

namespace App\Http\Controllers;

use App\Models\EmployeeEstimatedTime;
use App\Models\project;
use App\Models\ProjectEmployee;
use App\Models\User;
use Illuminate\Http\Request;

class projectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('project.list', ['projects' => $projects]);
    }

    public function create()
    {
        $employees = User::where('role', 1)->get();
        $customers = User::where('role', 0)->get();

        return view('project.add', [
            'employees' => $employees,
            'customers' => $customers
        ]);
    }

    public function store(Request $request)
    {
        $inputtedEmployees = getInputtedEmployees(
            $request
        );

        $estimated_time = getTimeFromHoursAndMinutes(
            $request->hours,
            $request->minutes
        );

        $newProject = Project::create([
            'title' => $request->title,
            'customer_id' => 1,
            'description' => $request->description,
            'estimated_time' => $estimated_time,
            'status' => 0
        ]);

        setEmployeesOfProject($newProject->id, $inputtedEmployees);

        return redirect('projects/' . $newProject->id . '/edit');
    }

    public function show($project_id)
    {
        $project = Project::where('id', $project_id)->first();
        $customer = User::where('id', $project->customer_id)->first();
        $employees_activity = EmployeeEstimatedTime::where('project_id', $project_id)
            ->get();

        $projectEmployeesIds = array_column(
            ProjectEmployee::select('employee_id')
                ->where('project_id', $project_id)->get()->toArray(),
            'employee_id'
        );

        $projectEmployees = User::where(
            'id',
            $projectEmployeesIds
        )->get();

        $project->estimated_time = getHoursAndMinutesFromTime(
            $project->estimated_time
        );

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

        return view('project.show', [
            'project' => $project,
            'customer' => $customer,
            'employees' => $projectEmployees,
            'employees_activity' => $employees_activity
        ]);
    }

    public function edit($project_id)
    {
        $project = Project::where('id', $project_id)->first();
        $allEmployees = User::where('role', 1)->get();
        $projectCustomer = User::where('id', $project->customer_id)->first();
        $customers = User::where('role', 0)->get();

        $projectEmployeesIds = ProjectEmployee::select('employee_id')
            ->where('project_id', $project_id)->get();

        $projectEmployees = User::where(
            'id',
            array_column($projectEmployeesIds->toArray(), 'employee_id')
        )->get();

        return view('project.edit', [
            'project' => $project,
            'allEmployees' => $allEmployees,
            'projectEmployees' => $projectEmployees,
            'customers' => $customers,
            'projectCustomer' => $projectCustomer
        ]);
    }

    public function update(Request $request, $project_id)
    {
        $project = Project::where('id', $project_id)->first();

        $inputtedEmployees = getInputtedEmployees(
            $request
        );

        $estimated_time = getTimeFromHoursAndMinutes(
            $request->hours,
            $request->minutes
        );

        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'estimated_time' => $estimated_time,
            'status' => $request->status
        ]);

        setEmployeesOfProject($project->id, $inputtedEmployees);

        return redirect('projects/' . $project->id . '/edit');
    }

    public function destroy($project_id)
    {
        $project = Project::where('id', $project_id)->first();
        $project->delete();
        return redirect()->intended('/dashboard');
    }

    public function changeEstimatedTime(Request $request, $project_id)
    {
        EmployeeEstimatedTime::create([
            'description' => $request->description,
            'employee_id' => auth()->user()->id,
            'project_id' => $project_id,
            'time_added' => getTimeFromHoursAndMinutes(
                $request->hours,
                $request->minutes
            ),
            'created_by_admin' => auth()->user()->role == 2
        ]);

        $project = Project::where('id', $project_id)->first();
        $project->update([
            'estimated_time' => $project->estimated_time + getTimeFromHoursAndMinutes(
                $request->hours,
                $request->minutes
            )
        ]);

        return redirect('projects/' . $project_id);
    }
}
