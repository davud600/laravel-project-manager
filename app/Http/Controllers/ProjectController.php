<?php

namespace App\Http\Controllers;

use App\Models\project;
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
        return view('project.add');
    }

    public function store(Request $request)
    {
        $newProject = Project::create([
            'title' => $request->title,
            'short_notes' => $request->short_notes,
            'price' => $request->price
        ]);

        return redirect('projects/' . $newProject->id . '/edit');
    }

    public function show(project $project)
    {
        //
    }

    public function edit(project $project)
    {
        return view('project.edit', [
            'project' => $project,
        ]);
    }

    public function update(Request $request, project $project)
    {
        $project->update([
            'title' => $request->title,
            'short_notes' => $request->short_notes,
            'price' => $request->price
        ]);

        return redirect('projects/' . $project->id . '/edit');
    }

    public function destroy(project $project)
    {
        $project->delete();
        return redirect('projects/');
    }
}
