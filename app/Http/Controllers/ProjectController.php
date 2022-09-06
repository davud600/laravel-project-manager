<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\EmployeeEstimatedTime;
use App\Models\project;
use App\Models\ProjectEmployee;
use App\Models\Request as ModelsRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return view('project.list', ['projects' => Project::all()]);
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

    public function store(StoreProjectRequest $request)
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
            'customer_id' => $request->customer,
            'description' => $request->description,
            'estimated_time' => $estimated_time
        ]);

        EmployeeEstimatedTime::create([
            'employee_id' => auth()->user()->id,
            'project_id' => $newProject->id,
            'time_added' => getTimeFromHoursAndMinutes(
                $request->hours,
                $request->minutes
            ),
            'created_by_admin' => true
        ]);

        setEmployeesOfProject($newProject->id, $inputtedEmployees);

        return redirect('projects/' . $newProject->id . '/edit');
    }

    public function show(int $id)
    {
        $project = Project::where('id', $id)->first();
        $employees_activity = EmployeeEstimatedTime::where('project_id', $id)
            ->get();
        $project_requests = ModelsRequest::where('project_id', $id)
            ->get();

        $projectEmployeesIds = array_column(
            ProjectEmployee::select('employee_id')
                ->where('project_id', $id)->get()->toArray(),
            'employee_id'
        );

        $projectEmployees = User::where(
            'id',
            $projectEmployeesIds
        )->get();

        return view('project.show', [
            'project' => $project,
            'employees' => $projectEmployees,
            'employees_activity' => $employees_activity,
            'project_requests' => $project_requests
        ]);
    }

    public function edit(int $id)
    {
        $project = Project::where('id', $id)->first();
        $allEmployees = User::where('role', 1)->get();
        $projectCustomer = User::where('id', $project->customer_id)->first();
        $customers = User::where('role', 0)->get();

        $projectEmployeesIds = ProjectEmployee::select('employee_id')
            ->where('project_id', $id)->get();

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

    public function update(UpdateProjectRequest $request, int $id)
    {
        $project = Project::where('id', $id)->first();

        $inputtedEmployees = getInputtedEmployees(
            $request
        );

        $estimated_time = getTimeFromHoursAndMinutes(
            $request->hours,
            $request->minutes
        );

        if ($project->estimated_time != $estimated_time) {
            EmployeeEstimatedTime::create([
                'employee_id' => auth()->user()->id,
                'project_id' => $id,
                'time_added' => getTimeFromHoursAndMinutes(
                    $request->hours,
                    $request->minutes
                ),
                'created_by_admin' => true
            ]);
        }

        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'estimated_time' => $estimated_time,
            'status' => $request->status
        ]);

        setEmployeesOfProject($project->id, $inputtedEmployees);

        return redirect('projects/' . $project->id . '/edit');
    }

    public function destroy(int $id)
    {
        $project = Project::where('id', $id)->first();
        $project->delete();

        return to_route('dashboard');
    }

    public function addEstimatedTime(Request $request, int $id)
    {
        EmployeeEstimatedTime::create([
            'description' => $request->description,
            'employee_id' => auth()->user()->id,
            'project_id' => $id,
            'time_added' => getTimeFromHoursAndMinutes(
                $request->hours,
                $request->minutes
            ),
            'created_by_admin' => false
        ]);

        $project = Project::where('id', $id)->first();
        $project->update([
            'estimated_time' => $project->estimated_time + getTimeFromHoursAndMinutes(
                $request->hours,
                $request->minutes
            )
        ]);

        return redirect('projects/' . $id);
    }
}
