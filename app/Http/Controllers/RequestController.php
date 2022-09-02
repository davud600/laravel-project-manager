<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Project;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function index()
    {
        $requests = ModelsRequest::all();
        return view('request.list', ['requests' => $requests]);
    }

    public function create(Request $req)
    {
        $project = null;
        if ($req->has('project_id')) {
            $project = Project::where('id', $req->get('project_id'))
                ->first();
        }

        return view('request.add', [
            'project' => $project
        ]);
    }

    public function store(Request $req)
    {
        $newRequest = ModelsRequest::create([
            'title' => $req->title,
            'description' => $req->description,
            'project_id' => $req->get('project_id')
        ]);

        return redirect('requests/' . $newRequest->id . '/edit?project_id=' . $req->get('project_id'));
    }

    public function show($id)
    {
        $request = ModelsRequest::where('id', $id)->first();
        $project = Project::where('id', $request->project_id)->first();
        $messages = Message::where('request_id', $id)->get();

        return view('request.show', [
            'request' => $request,
            'project' => $project,
            'messages' => $messages
        ]);
    }

    public function edit(Request $req, $id)
    {
        $project = null;
        if ($req->has('project_id')) {
            $project = Project::where('id', $req->get('project_id'))
                ->first();
        }

        $request = ModelsRequest::where('id', $id)->first();

        return view('request.edit', [
            'request' => $request,
            'project' => $project
        ]);
    }

    public function update(Request $req, $id)
    {
        $request = ModelsRequest::where('id', $id)->first();

        $request->update([
            'title' => $req->title,
            'description' => $req->description
        ]);

        return redirect('requests/' . $request->id . '/edit?project_id=' . $req->get('project_id'));
    }

    public function destroy($request_id)
    {
        $request = ModelsRequest::where('id', $request_id)->first();
        $request->delete();
        return redirect()->intended('/dashboard');
    }

    public function changeStatus($request_id)
    {
        $request = ModelsRequest::where('id', $request_id)
            ->first();

        $request->update([
            'status' => $request->status == 0 ? 1 : 0
        ]);

        return redirect('projects/' . $request->project_id);
    }
}
