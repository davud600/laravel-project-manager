<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request\StoreRequestRequest;
use App\Http\Requests\Request\UpdateRequestRequest;
use App\Models\Message;
use App\Models\Project;
use App\Models\Request as ModelsRequest;
use App\Models\UserReadMessage;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function __construct(
        ModelsRequest $request,
        Project $project,
        Message $message,
        UserReadMessage $userReadMessage
    ) {
        $this->request = $request;
        $this->project = $project;
        $this->message = $message;
        $this->userReadMessage = $userReadMessage;
    }

    public function index()
    {
        $requests = $this->request->all();
        return view('request.list', ['requests' => $requests]);
    }

    public function create(Request $req)
    {
        $project = null;
        if ($req->has('project_id')) {
            $project = $this->project->getById($req->get('project_id'));
        }

        return view('request.add', [
            'project' => $project
        ]);
    }

    public function store(StoreRequestRequest $req)
    {
        $newRequest = $this->request->create([
            'title' => $req->title,
            'description' => $req->description,
            'project_id' => $req->get('project_id')
        ]);

        return redirect('requests/' . $newRequest->id . '/edit?project_id=' . $req->get('project_id'));
    }

    public function show(int $id)
    {
        $request = $this->request->getById($id);
        $project = $this->project->getById($request->project_id);
        $messages = $this->message->getMessagesOfRequest(
            $id,
            withUser: true
        );
        $this->userReadMessage->readMessages(
            $messages,
            auth()->user()->id
        );

        return view('request.show', [
            'request' => $request,
            'project' => $project,
            'messages' => $messages
        ]);
    }

    public function edit(Request $req, int $id)
    {
        $project = null;
        if ($req->has('project_id')) {
            $project = $this->project->getById($req->get('project_id'));
        }

        $request = $this->request->getById($id);

        return view('request.edit', [
            'request' => $request,
            'project' => $project
        ]);
    }

    public function update(UpdateRequestRequest $req, int $id)
    {
        $request = $this->request->getById($id);

        $request->update([
            'title' => $req->title,
            'description' => $req->description
        ]);

        return redirect('requests/' . $request->id . '/edit?project_id=' . $req->get('project_id'));
    }

    public function destroy(int $id)
    {
        $request = $this->request->getById($id);
        $request->delete();

        return to_route('dashboard');
    }

    public function changeStatus(int $id)
    {
        $request = $this->request->getById($id);

        $request->update([
            'status' => $request->status == 0 ? 1 : 0
        ]);

        return redirect('projects/' . $request->project_id);
    }
}
