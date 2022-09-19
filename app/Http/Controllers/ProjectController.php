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
        $newProject = $this->project->create($request->all());
        $this->storeProjectEmployees($request, $newProject->id);

        return redirect('projects/' . $newProject->id . '/edit');
    }

    public function show(Project $project)
    {
        $employeeActivity = $this->employeeEstimatedTime->getActivityOfProject(
            $project->id,
            withEmployee: true
        );
        $projectRequests = $this->request->getRequestsOfProject($project->id);
        $projectEmployees = $this->projectEmployee->getEmployeesOfProject($project->id);

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
        $projectEmployees = $this->projectEmployee->getEmployeesOfProject($project->id);

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
        $project->update($request->all());
        $this->storeProjectEmployees($request, $project->id);

        return redirect('projects/' . $project->id . '/edit');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return to_route('dashboard');
    }

    public function addEstimatedTime(Request $request, Project $project)
    {
        $attributes = $request->all();
        $attributes['project_id'] = $project->id;
        $this->employeeEstimatedTime->create($attributes);
        $project->update([
            'estimated_time' => $project->estimated_time
        ]);

        return redirect('projects/' . $project->id);
    }

    private function storeProjectEmployees(Request $request, int $projectId)
    {
        // Set employees
        $inputtedEmployees = getInputtedEmployees(
            $request
        );
        setEmployeesOfProject($projectId, $inputtedEmployees);
    }
}
