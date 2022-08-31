<?php

namespace App\Http\Controllers;

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
        $inputtedEmployees = $this->getInputtedEmployees(
            $request
        );

        $estimated_time = $this->getTimeFromHoursAndMinutes(
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

        $this->setEmployeesOfProject($newProject->id, $inputtedEmployees);

        // foreach ($inputtedEmployees as $employee) {
        //     ProjectEmployee::create([
        //         'project_id' => $newProject->id,
        //         'employee_id' => $employee
        //     ]);
        // }

        return redirect('projects/' . $newProject->id . '/edit');
    }

    public function show($project_id)
    {
        $project = Project::where('id', $project_id)->first();
        $customer = User::where('id', $project->customer_id)->first();

        $projectEmployeesIds = ProjectEmployee::select('employee_id')
            ->where('project_id', $project_id)->get();

        $projectEmployees = User::where(
            'id',
            array_column($projectEmployeesIds->toArray(), 'employee_id')
        )->get();

        return view('project.show', [
            'project' => $project,
            'customer' => $customer,
            'employees' => $projectEmployees
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

        $inputtedEmployees = $this->getInputtedEmployees(
            $request
        );

        $estimated_time = $this->getTimeFromHoursAndMinutes(
            $request->hours,
            $request->minutes
        );

        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'estimated_time' => $estimated_time,
            'status' => $request->status
        ]);

        $this->setEmployeesOfProject($project->id, $inputtedEmployees);

        return redirect('projects/' . $project->id . '/edit');
    }

    public function destroy($project)
    {
        $project->delete();
        return redirect('projects/');
    }

    private function getTimeFromHoursAndMinutes($user_hours, $user_minutes)
    {
        $user_hours = $user_hours ? $user_hours : 0;
        $user_minutes = $user_minutes ? $user_minutes : 0;

        return ($user_hours * 60) + $user_minutes;
    }

    private function getInputtedEmployees($request)
    {
        $MAX_EMPLOYEES = 100;
        $inputedEmployees = [];
        for ($i = 0; $i < $MAX_EMPLOYEES; $i++) {
            if ($request->input('employee' . $i) == null) {
                continue;
            }

            if (in_array($request->input('employee' . $i), $inputedEmployees)) {
                continue;
            }

            array_push($inputedEmployees, $request->input('employee' . $i));
        }

        return $inputedEmployees;
    }

    private function setEmployeesOfProject($project_id, $employee_ids)
    {
        // del all initial employees if thers any
        $this->deleteAllEmployeesOfProject($project_id);

        $project_employees = [];
        foreach ($employee_ids as $employee_id) {
            array_push($project_employees, [
                'project_id' => $project_id,
                'employee_id' => $employee_id
            ]);
        }

        ProjectEmployee::insert($project_employees);
    }

    private function deleteAllEmployeesOfProject($project_id)
    {
        ProjectEmployee::where('project_id', $project_id)
            ->delete();
    }
}
