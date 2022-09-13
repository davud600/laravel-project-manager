<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\EmployeeEstimatedTime;
use App\Models\project;
use App\Models\ProjectEmployee;
use App\Models\Request as ModelsRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(
        User $user,
        Project $project,
        ModelsRequest $request,
        ProjectEmployee $projectEmployee,
        EmployeeEstimatedTime $employeeEstimatedTime
    ) {
        $this->user = $user;
        $this->project = $project;
        $this->request = $request;
        $this->projectEmployee = $projectEmployee;
        $this->employeeEstimatedTime = $employeeEstimatedTime;
    }

    public function index()
    {
        $projects = $this->project->all();
        return view('project.list', ['projects' => $projects]);
    }

    public function create()
    {
        $employees = $this->user->getEmployees();
        $customers = $this->user->getCustomers();

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

        $newProject = $this->project->create([
            'title' => $request->title,
            'customer_id' => $request->customer,
            'description' => $request->description,
            'estimated_time' => $estimated_time
        ]);

        $this->employeeEstimatedTime->create([
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

    public function show(Project $project)
    {
        $employeeActivity = $this->employeeEstimatedTime->getActivityOfProject(
            $project->id,
            withEmployee: true
        );
        $projectRequests = $this->request->getRequestsOfProject($project->id);

        $projectEmployeesIds = array_column(
            $this->projectEmployee->getEmployeesOfProject($project->id)->toArray(),
            'employee_id'
        );

        $projectEmployees = $this->user->getUsersByIds($projectEmployeesIds);

        return view('project.show', [
            'project' => $project,
            'employees' => $projectEmployees,
            'employees_activity' => $employeeActivity,
            'project_requests' => $projectRequests
        ]);
    }

    public function edit(Project $project)
    {
        $allEmployees = $this->user->getEmployees();
        $projectCustomer = $this->user->getById($project->customer_id);
        $customers = $this->user->getCustomers();

        $projectEmployeesIds = array_column(
            $this->projectEmployee->getEmployeesOfProject($project->id)->toArray(),
            'employee_id'
        );

        $projectEmployees = $this->user->getUsersByIds($projectEmployeesIds);

        return view('project.edit', [
            'project' => $project,
            'allEmployees' => $allEmployees,
            'projectEmployees' => $projectEmployees,
            'customers' => $customers,
            'projectCustomer' => $projectCustomer
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $inputtedEmployees = getInputtedEmployees(
            $request
        );

        $estimated_time = getTimeFromHoursAndMinutes(
            $request->hours,
            $request->minutes
        );

        if ($project->estimated_time != $estimated_time) {
            $this->employeeEstimatedTime->create([
                'employee_id' => auth()->user()->id,
                'project_id' => $project->id,
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

    public function destroy(Project $project)
    {
        $project->delete();
        return to_route('dashboard');
    }

    public function addEstimatedTime(Request $request, Project $project)
    {
        $this->employeeEstimatedTime->create([
            'description' => $request->description,
            'employee_id' => auth()->user()->id,
            'project_id' => $project->id,
            'time_added' => getTimeFromHoursAndMinutes(
                $request->hours,
                $request->minutes
            ),
            'created_by_admin' => false
        ]);

        $project->update([
            'estimated_time' => $project->estimated_time + getTimeFromHoursAndMinutes(
                $request->hours,
                $request->minutes
            )
        ]);

        return redirect('projects/' . $project->id);
    }
}
