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
        EmployeeEstimatedTime $employeeEstimatedTime
    ) {
        $this->user = $user;
        $this->project = $project;
        $this->employeeEstimatedTime = $employeeEstimatedTime;
    }

    public function index()
    {
        $projects = $this->project->all();
        return view('project.list', ['projects' => $projects]);
    }

    public function create()
    {
        return view('project.add', [
            'employees' => $this->user->getEmployees(),
            'customers' => $this->user->getCustomers()
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

        return view('project.show', [
            'project' => $project,
            'employees' => $project->employees->pluck('employee'),
            'employees_activity' => $employeeActivity,
            'project_requests' => $project->requests
        ]);
    }

    public function edit(Project $project)
    {
        return view('project.edit', [
            'project' => $project,
            'allEmployees' => $this->user->getEmployees(),
            'projectEmployees' => $project->employees->pluck('employee'),
            'customers' => $this->user->getCustomers(),
            'projectCustomer' => $this->user->getById($project->customer_id)
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
