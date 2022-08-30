<?php

namespace App\Http\Controllers;

use App\Models\project;
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

        return view('project.add', [
            'employees' => $employees
        ]);
    }

    public function store(Request $request)
    {
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

        return redirect('projects/' . $newProject->id . '/edit');
    }

    public function show($project_id)
    {
        $project = Project::where('id', $project_id)->first();
        $customer = User::where('id', $project->customer_id)->first();

        return view('project.show', [
            'project' => $project,
            'customer' => $customer,
            'employees' => []
        ]);
    }

    public function edit($project_id)
    {
        $project = Project::where('id', $project_id)->first();
        $all_employees = User::where('role', 1)->get();

        return view('project.edit', [
            'project' => $project,
            'all_employees' => $all_employees
        ]);
    }

    public function update(Request $request, $project_id)
    {
        $project = Project::where('id', $project_id)->first();

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
}
